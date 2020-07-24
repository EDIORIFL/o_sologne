<?php 
namespace App\Form\DataTransformer;

use App\Entity\ProspectStatus;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class ProspectStatusToNumberTransformer implements DataTransformerInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Transforms an object (prospectStatus) to a string (number).
     *
     * @param  ProspectStatus|null $prospectStatus
     * @return string
     */
    public function transform($prospectStatus)
    {
        if (null === $prospectStatus) {
            return '';
        }

        return $prospectStatus->getId();
    }

    /**
     * Transforms a string (number) to an object (prospectStatus).
     *
     * @param  string $prospectStatusNumber
     * @return ProspectStatus|null
     * @throws TransformationFailedException if object (prospectStatus) is not found.
     */
    public function reverseTransform($prospectStatusNumber)
    {
        // no prospectStatus number? It's optional, so that's ok
        if (!$prospectStatusNumber) {
            return;
        }

        $prospectStatus = $this->entityManager
            ->getRepository(ProspectStatus::class)
            // query for the prospectStatus with this id
            ->find($prospectStatusNumber)
        ;

        if (null === $prospectStatus) {
            // causes a validation error
            // this message is not shown to the prospectStatus
            // see the invalid_message option
            throw new TransformationFailedException(sprintf(
                'An prospectStatus with number "%s" does not exist!',
                $prospectStatusNumber
            ));
        }

        return $prospectStatus;
    }
}