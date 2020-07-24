<?php 
namespace App\Form\DataTransformer;

use App\Entity\SupportType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class SupportTypeToNumberTransformer implements DataTransformerInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Transforms an object (support) to a string (number).
     *
     * @param  SupportType|null $supportType
     * @return string
     */
    public function transform($supportType)
    {
        // dd($supportType);
        if (null === $supportType) {
            return '';
        }

        return $supportType->getId();
    }

    /**
     * Transforms a string (number) to an object (supportType).
     *
     * @param  string $supportTypeNumber
     * @return SupportType|null
     * @throws TransformationFailedException if object (supportType) is not found.
     */
    public function reverseTransform($supportTypeNumber)
    {
        // no supportType number? It's optional, so that's ok
        if (!$supportTypeNumber) {
            return;
        }

        $supportType = $this->entityManager
            ->getRepository(SupportType::class)
            // query for the supportType with this id
            ->find($supportTypeNumber)
        ;

        if (null === $supportType) {
            // causes a validation error
            // this message is not shown to the user
            // see the invalid_message option
            throw new TransformationFailedException(sprintf(
                'A supportType with number "%s" does not exist!',
                $supportTypeNumber
            ));
        }

        return $supportType;
    }
}