<?php
/**
 * Task fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Task;
use Doctrine\Persistence\ObjectManager;

/**
 * Class TaskFixtures.
 */
class TaskFixtures extends AbstractBaseFixtures
{
    /**
     * Load data.
     *
     * @param ObjectManager $manager Persistence object manager
     */
    public function loadData(ObjectManager $manager): void
    {
        for ($i = 0; $i < 50; ++$i) {
            $task = new Task();
            $task->setTitle($this->faker->sentence);
            $task->setDescription($this->faker->sentence);
            $this->manager->persist($task);
        }

        $manager->flush();
    }
}
