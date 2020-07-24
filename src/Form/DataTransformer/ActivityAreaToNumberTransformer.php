<?php 
namespace App\Form\DataTransformer;

use App\Entity\ActivityArea;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class ActivityAreaToNumberTransformer implements DataTransformerInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Transforms an object (activityArea) to a string (number).
     *
     * @param  ActivityArea|null $activityArea
     * @return string
     */
    public function transform($activityArea)
    {
        if (null === $activityArea) {
            return '';
        }

        return $activityArea->getId();
    }

    /**
     * Transforms a string (number) to an object (activityArea).
     *
     * @param  string $activityAreaNumber
     * @return ActivityArea|null
     * @throws TransformationFailedException if object (activityArea) is not found.
     */
    public function reverseTransform($activityAreaNumber)
    {
        // no activityArea number? It's optional, so that's ok
        if (!$activityAreaNumber) {
            return;
        }

        $activityArea = $this->entityManager
            ->getRepository(ActivityArea::class)
            // query for the activityArea with this id
            ->find($activityAreaNumber)
        ;

        if (null === $activityArea) {
            // causes a validation error
            // this message is not shown to the user
            // see the invalid_message option
            throw new TransformationFailedException(sprintf(
                'A activityArea with number "%s" does not exist!',
                $activityAreaNumber
            ));
        }

        return $activityArea;
    }
}