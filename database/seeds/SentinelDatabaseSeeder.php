<?php



use Illuminate\Database\Seeder;



class SentinelDatabaseSeeder extends Seeder

{

    /**

     * Run the database seeds.

     *

     * @return void

     */

    public function run()

    {

        // Create Users

        DB::table('users')->truncate();



        $admin = Sentinel::getUserRepository()->create(array(

            'email'    => 'admin@admin.com',

            'password' => 'admin'

        ));



        $user = Sentinel::getUserRepository()->create(array(

            'email'    => 'user@user.com',

            'password' => 'user'

        ));



        // Create Activations

        DB::table('activations')->truncate();

        $code = Activation::create($admin)->code;

        Activation::complete($admin, $code);

        $code = Activation::create($user)->code;

        Activation::complete($user, $code);



        // Create Roles

        $administratorRole = Sentinel::getRoleRepository()->create(array(

            'name' => 'Administrator',

            'slug' => 'administrator',

            'permissions' => array(

                'users.create' => true,

                'users.update' => true,

                'users.view' => true,

                'users.destroy' => true,

                'roles.create' => true,

                'roles.update' => true,

                'roles.view' => true,

                'roles.delete' => true

            )

        ));

        $agentRole = Sentinel::getRoleRepository()->create(array(
            'name' => 'Agent',
            'slug' => 'agent',
            'permissions' => array()
        ));

        $salesmanRole = Sentinel::getRoleRepository()->create(array(
            'name' => 'Salesman',
            'slug' => 'salesman',
            'permissions' => array()
        ));

        $operatorRole = Sentinel::getRoleRepository()->create(array(
            'name' => 'Salesman',
            'slug' => 'salesman',
            'permissions' => array()
        ));


        // Assign Roles to Users

        $administratorRole->users()->attach($admin);

        $agentRole->users()->attach($user);

    }

}