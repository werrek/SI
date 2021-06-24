<?php
/**
 * Note fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Note;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * Class NoteFixtures.
 */
class NoteFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    /**
     * Load data.
     *
     * @param ObjectManager $manager Persistence object manager
     */
    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(20, 'notes', function () {
            $note = new Note();
            $note->setTitle($this->faker->sentence);
            $note->setDescription($this->faker->sentence);
            $note->setDate($this->faker->dateTimeBetween('-100 days', '-1 days'));
            $note->setCategory($this->getRandomReference('categories'));

            return $note;
        });

        $manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on.
     *
     * @return array Array of dependencies
     */
    public function getDependencies(): array
    {
        return [CategoryFixtures::class];
    }
}
