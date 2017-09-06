<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Event;
use App\Models\EventUser;
use App\Models\Legend;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use DateTime;
use DateInterval;
use DB;

class CalendarController extends Controller
{

    public function index()
    {
        $legends = Legend::all();

        $data = [
            'legends' => $legends,
        ];

        return view('pages.calendar', $data);
    }

    public function save(Request $request, $event_id = NULL)
    {
        $newEvent = true;

        // New event
        if (is_null($event_id)) {
            $event = new Event();
        } // Update event
        else {
            $newEvent = false;
            $event = Event::find($event_id);
        }

        $event->title = $request->input('title');
        $event->description = $request->input('description');
        $event->legend_id = $request->get('legend');
        $event->all_day = $request->input('allDay') ? 1 : 0;

        $dateS = $request->input('startDate');
        $dateE = $request->input('endDate');

        if (($event->all_day == 1)) {
            $format = Helper::setFormatDate() . " H:i:s";
            $dateS .= ' 00:00:00';
            $dateE .= ' 00:00:00';
        } else {
            $format = Helper::setFormatDate() . ' H:i';
            $dateS .= ' ' . $request->input('timepickerStart');
            $dateE .= ' ' . $request->input('timepickerEnd');
        }

        $startDate = DateTime::createFromFormat($format, $dateS);
        $event->start_date = $startDate->format('Y-m-d H:i:s');

        $endDate = DateTime::createFromFormat($format, $dateE);
        $event->end_date = $endDate->format('Y-m-d H:i:s');

        if (!$newEvent) {
            $hasChanges = false;
            $changes = $event->getDirty();

            if (count($changes) > 0) {
                $hasChanges = true;
                foreach ($changes as $key => $value) {
                    $values[] = $event->getChanges($key, $value);
                }
                $values = implode(', ', $values);

                $message = __('notification.update_event', ['event' => $event->title, 'values' => $values]);
            }
        }

        try {
            $event->save();

            $new = $recipients = Helper::getRecipients();

            if (!$newEvent) {
                $members = $event->events_user->all();

                foreach ($members as $member) {
                    if (in_array($member->user_id, $recipients)) {
                        unset($new[array_search($member->user_id, $new)]);
                    } else {
                        EventUser::whereUserId($member->user_id)->delete();
                        Notification::add(__('notification.delete_member_event', ['event' => $event->title, 'member' => User::find($member->user_id)->getFullName()]), route('event.delete', $event_id), $event->notification_type, $event->id, $members);
                    }
                }
            }


            foreach ($new as $recipient) {
                $event_user = new EventUser();
                $event_user->event_id = $event->id;
                $event_user->user_id = $recipient;

                try {
                    $event_user->save();
                    if (!$newEvent) {
                        Notification::add(__('notification.new_member_event', ['event' => $event->title, 'member' => User::find($recipient)->getFullName()]), route('calendar'), $event->notification_type, $event->id, $recipients, false);
                    }
                } catch (QueryException $ex) {
                    Helper::logExceptionSql($ex);
                    return \Redirect::route('calendar')->with('danger', __('calendar.new_member_ko'))->withInput();
                }

            }

            if ($newEvent) {
                Notification::add(__('notification.new_event', ['event' => $event->title]), route('calendar'), $event->notification_type, $event->id, $recipients, false);
            } else {
                if ($hasChanges) {
                    Notification::add($message, route('calendar'), $event->notification_type, $event_id, $recipients, false);
                }
            }

            return \Redirect::route('calendar');

        } catch (QueryException $ex) {
            Helper::logExceptionSql($ex);
            return \Redirect::route('calendar')->with('danger', __('calendar.event_change_ko'))->withInput();
        }
    }

    public function get()
    {
        $allEvents = EventUser::whereUserId((\Auth::user()->id))->with('event')->get();

        $events = array();
        foreach ($allEvents as $event) {
            $events[] = array('title' => $event->event->title, 'start' => $event->event->start_date, 'end' => $event->event->end_date, 'allDay' => $event->event->all_day == 1, 'className' => $event->event->legend->colour, 'id' => $event->event->id,);
        }

        return json_encode($events);
    }

    public function detail($event_id)
    {
        $event = Event::whereId($event_id)->with(array('events_user' => function ($query) {
            $query->select('event_id', 'user_id')->with(array('user' => function ($query) {
                $query->select('id', DB::raw("CONCAT(CONCAT(name,' '),surname) AS display_name"))->whereNotIn('id', [\Auth::user()->id]);
            }));
        }))->get();

        return $event;
    }

    public function drop($event_id, $eventDate)
    {

        $event = Event::find($event_id);

        if (!is_null($event)) {
            $eventDate = substr($eventDate, 0, 10) . substr($event->start_date, 11);
            $eventStart = DateTime::createFromFormat('Y-m-d H:i:s', $eventDate);

            $startDate = DateTime::createFromFormat('Y-m-d H:i:s', $event->start_date);
            $endDate = DateTime::createFromFormat('Y-m-d H:i:s', $event->end_date);

            $diff = $startDate->diff($eventStart);
            $days = (int)$diff->format('%R%a');
            $interval = new DateInterval('P' . abs($days) . 'D');

            if ($days < 0) {
                $eventStartDate = $startDate->sub($interval);
                $eventEndDate = $endDate->sub($interval);
            } else {
                $eventStartDate = $startDate->add($interval);
                $eventEndDate = $endDate->add($interval);
            }

            $event->start_date = $eventStartDate->format('Y-m-d H:i:s');
            $event->end_date = $eventEndDate->format('Y-m-d H:i:s');

            $changes = $event->getDirty();

            foreach ($changes as $key => $value) {
                $values[] = $event->getChanges($key, $value);
            }
            $values = implode(', ', $values);
            $message = __('notification.update_event', ['event' => $event->title, 'values' => $values]);

            try {
                $event->save();

                Notification::add($message, route('calendar'), $event->notification_type, $event_id, $event->events_user->all());

            } catch (QueryException $ex) {
                Helper::logExceptionSql($ex);
                return \Redirect::route('calendar')->with('danger', __('calendar.event_change_ko'))->withInput();
            }
        } else {
            return \Redirect::route('calendar')->with('danger', __('calendar.event_not_found'))->withInput();
        }

    }

    public function delete($event_id)
    {
        $event = Event::find($event_id);

        if (!is_null($event)) {
            $success = false;
            if (\Auth::user()->isAdmin() || EventUser::whereEventId($event_id)->count() == 1) {
                $success = true;
            }

            if ($success) {
                try {
                    $event->delete();

                    Notification::add(__('notification.delete_event', ['event' => $event->title]), route('calendar'), $event->notification_type, $event->id, $event->events_user->all());

                    return \Redirect::route('calendar');

                } catch (QueryException $ex) {
                    Helper::logExceptionSql($ex);
                    return \Redirect::route('calendar')->with('danger', __('calendar.event_delete_ko'))->withInput();
                }
            } else {
                return \Redirect::route('calendar')->with('danger', __('auth.forbidden'))->withInput();
            }

        } else {
            return \Redirect::route('calendar')->with('danger', __('calendar.event_not_found'))->withInput();
        }
    }

    public function getMonthly()
    {
        $allEvents = EventUser::whereUserId((\Auth::user()->id))->with('event')->whereHas('event', function ($query) {
            $query->whereYear('start_date', date('Y'));
        })->get();

        $events = array();
        $total = array();
        foreach ($allEvents as $event) {
            $date = new DateTime($event->event->start_date);
            $month = $date->format('M');

            $events[$month] = (isset($events[$month])) ? $events[$month]+1 : 1;
        }

        foreach ($events as $key => $value){
            $total[] = array('month' =>$key, 'value' =>$value);
        }
        return $total;
    }
}
