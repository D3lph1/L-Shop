<?php
declare(strict_types = 1);

use App\Entity\Enchantment;
use App\Repository\Enchantment\EnchantmentRepository;
use App\Services\Item\Enchantment\Enchantments;
use Illuminate\Database\Seeder;

class EnchantmentsSeeder extends Seeder
{
    private $enchantments = [
        Enchantments::PROTECTION => [
            'max' => 4,
            'group' => 'armor'
        ],
        Enchantments::FIRE_PROTECTION => [
            'max' => 4,
            'group' => 'armor'
        ],
        Enchantments::FEATHER_FALLING => [
            'max' => 4,
            'group' => 'armor'
        ],
        Enchantments::BLAST_PROTECTION => [
            'max' => 4,
            'group' => 'armor'
        ],
        Enchantments::PROJECTILE_PROTECTION => [
            'max' => 4,
            'group' => 'armor'
        ],
        Enchantments::RESPIRATION => [
            'max' => 3,
            'group' => 'armor'
        ],
        Enchantments::AQUA_AFFINITY => [
            'max' => 1,
            'group' => 'armor'
        ],
        Enchantments::THORNS => [
            'max' => 3,
            'group' => 'armor'
        ],

        Enchantments::SHARPNESS => [
            'max' => 5,
            'group' => 'weapons'
        ],
        Enchantments::SMITE => [
            'max' => 5,
            'group' => 'weapons'
        ],
        Enchantments::BANE_OF_ARTHROPODS => [
            'max' => 5,
            'group' => 'weapons'
        ],
        Enchantments::KNOCKBACK => [
            'max' => 2,
            'group' => 'weapons'
        ],
        Enchantments::FIRE_ASPECT => [
            'max' => 2,
            'group' => 'weapons'
        ],
        Enchantments::LOOTING => [
            'max' => 3,
            'group' => 'weapons'
        ],

        Enchantments::EFFICIENCY => [
            'max' => 5,
            'group' => 'tools'
        ],
        Enchantments::SILK_TOUCH => [
            'max' => 1,
            'group' => 'tools'
        ],
        Enchantments::FORTUNE => [
            'max' => 3,
            'group' => 'tools'
        ],

        Enchantments::POWER => [
            'max' => 5,
            'group' => 'bows'
        ],
        Enchantments::PUNCH => [
            'max' => 2,
            'group' => 'bows'
        ],
        Enchantments::FLAME => [
            'max' => 1,
            'group' => 'bows'
        ],
        Enchantments::INFINITY => [
            'max' => 1,
            'group' => 'bows'
        ],

        Enchantments::UNBREAKING => [
            'max' => 3,
            'group' => null
        ],
    ];

    public function run(EnchantmentRepository $repository): void
    {
        $repository->deleteAll();

        foreach ($this->enchantments as $id => $data) {
            $enchantment = new Enchantment($id, $data['max'], $data['group']);
            $repository->create($enchantment);
        }
    }
}
