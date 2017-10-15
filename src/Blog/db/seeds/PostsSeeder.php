<?php


use Phinx\Seed\AbstractSeed;

class PostsSeeder extends AbstractSeed
{
    public function run()
    {
        $data = [];
        $faker = \Faker\Factory::create('es_VE');

        for ($i = 0; $i < 100; ++$i) {
            $date = $faker->unixTime('now');
            $data[] = [
                'name' => $faker->company,
                'slug' => $faker->slug,
                'content' => $faker->text(3000),
                'create_at' => date('Y-m-a H:i:s', $date),
                'update_at' => date('Y-m-a H:i:s', $date)
            ];
        }
        $this->table('posts')
            ->insert($data)
            ->save();
    }
}
