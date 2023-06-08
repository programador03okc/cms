<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->truncateTables([
    		'admin.art_types',
    		'admin.sections',
    		'admin.business_types',
    		'admin.store_shops',
    		'admin.currencies',
    		'admin.type_changes',
    		'admin.categories',
    		'admin.subcategories',
    		'admin.marks',
    		'admin.units',
    		'admin.features',
    		'admin.values',
    		'admin.feature_values',
    		'admin.users',
        ]);
        
        $this->call([
            ArtTypeSeeder::class,
            SectionSeeder::class,
            BusinessTypeSeeder::class,
            StoreShopSeeder::class,
            CurrencySeeder::class,
            TypeChangeSeeder::class,
            CategorySeeder::class,
            SubcategorySeeder::class,
            MarkSeeder::class,
            UnitSeeder::class,
            FeatureSeeder::class,
            ValueSeeder::class,
            FeatureValueSeeder::class,
            UserSeeder::class,
        ]);
    }

    protected function truncateTables(array $tables)
    {
    	// DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        foreach ($tables as $table)
        {
    		DB::table($table)->truncate();
    	}
    	// DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
}
