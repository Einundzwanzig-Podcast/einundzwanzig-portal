<?php

namespace App\Console\Commands\Database;

use Illuminate\Console\Command;

class CreatePermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permissions:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $actions = [
            '*',
            'viewAny',
            'view',
            'create',
            'update',
            'delete',
            'restore',
            'forceDelete',
        ];
        $permissions = [
            'PermissionPolicy',
            'RolePolicy',
            'BitcoinEventPolicy',
            'BookCasePolicy',
            'CategoryPolicy',
            'CityPolicy',
            'CountryPolicy',
            'CourseEventPolicy',
            'CoursePolicy',
            'EpisodePolicy',
            'LecturerPolicy',
            'LibraryItemPolicy',
            'LibraryPolicy',
            'MeetupEventPolicy',
            'MeetupPolicy',
            'OrangePillPolicy',
            'ParticipantPolicy',
            'PodcastPolicy',
            'RegistrationPolicy',
            'TeamPolicy',
            'UserPolicy',
            'VenuePolicy',
            'CommentPolicy',
            'NovaAdminPolicy',
        ];
        foreach ($permissions as $permission) {
            $this->info($permission);
            foreach ($actions as $action) {
                $this->info($action);
                \Spatie\Permission\Models\Permission::firstOrCreate([
                    'name' => $permission.'.'.$action,
                ], [
                    'guard_name' => 'web',
                ]);
            }
        }

        return Command::SUCCESS;
    }
}
