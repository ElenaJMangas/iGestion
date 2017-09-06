<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // User roles
        $roles = [
            [
                'name' => "Admin",
                'description' => "User with all privileges granted"
            ], [
                'name' => "User",
                'description' => "User with some privileges granted"
            ]
        ];

        DB::table('roles')->insert($roles);

        // The First Admin and user
        $users = [
            [
                'name' => "John",
                'surname' => "Doe",
                'username' => "jhondoe",
                'email' => "jhondoe@gmail.com",
                'password' => bcrypt('JhonDoe1'),
                'role_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => "Elena",
                'surname' => "Mangas",
                'username' => "elenamangasadmin",
                'email' => "elenajesus.mangasperez@gmail.com",
                'password' => bcrypt('0raOpib3'),
                'role_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'name' => "Elena",
                'surname' => "Mangas",
                'username' => "elenamangas",
                'email' => "elenajesus.mangasperez@alum.uca.es",
                'password' => bcrypt('0raOpib3'),
                'role_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ];
        DB::table('users')->insert($users);

        $priorities = [
            [
                'priority' => 'mild'
            ], [
                'priority' => 'medium'
            ], [
                'priority' => 'high'
            ], [
                'priority' => 'urgent'
            ]
        ];

        DB::table('priorities')->insert($priorities);

        $projects = [
            [
                'user_id' => 1,
                'title' => "Example Project",
                'description' => 'This is a description project example',
                'priority_id' => 1,
                'status_id' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ];
        DB::table('projects')->insert($projects);

        $members = [
            [
                'project_id' => 1,
                'user_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ];
        DB::table('members')->insert($members);

        $status = [
            [
                'id' => 1,
                'status' => 'pending'
            ],
            [
                'id' => 2,
                'status' => 'inProgress'
            ],
            [
                'id' => 3,
                'status' => 'done'
            ],
        ];
        DB::table('tasks_status')->insert($status);

        $tasks = [
            [
                'user_id' => 1,
                'title' => "Example Task",
                'description' => 'Description Task Example',
                'priority_id' => 1,
                'status_id' => 2,
                'target_end_date' => '2016-11-25 12:00:00',
                'actual_end_date' => Carbon::now(),
                'created_at' => '2016-08-05 09:00:00',
                'updated_at' => Carbon::now(),
            ]
        ];
        DB::table('tasks')->insert($tasks);

        $tasks_user = [
            [
                'user_id' => 1,
                'task_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];
        DB::table('tasks_user')->insert($tasks_user);

        $legend = [
            [
                'id' => 1,
                'colour' => 'back-blue',
                'category' => 'work'
            ],
            [
                'id' => 2,
                'colour' => 'back-red',
                'category' => 'important'
            ],
            [
                'id' => 3,
                'colour' => 'back-green',
                'category' => 'holidays'
            ],
            [
                'id' => 4,
                'colour' => 'back-muted',
                'category' => 'meeting'
            ],
            [
                'id' => 5,
                'colour' => 'back-yellow',
                'category' => 'sick'
            ],
        ];
        DB::table('legend')->insert($legend);


    }

}
