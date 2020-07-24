<?php 
namespace App\Form\DataTransformer;

use App\Entity\Prospect;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class ProspectToNumberTransformer implements DataTransformerInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Transforms an object (prospect) to a string (number).
     *
     * @param  Prospect|null $prospect
     * @return string
     */
    public function transform($prospect)
    {
        if (null === $prospect) {
            return '';
        }

        return $prospect->getId();
    }

    /**
     * Transforms a string (number) to an object (prospect).
     *
     * @param  string $prospectNumber
     * @return Prospect|null
     * @throws TransformationFailedException if object (prospect) is not found.
     */
    public function reverseTransform($prospectNumber)
    {
        // no prospect number? It's optional, so that's ok
        if (!$prospectNumber) {
            return;
        }

        $prospect = $this->entityManager
            ->getRepository(Prospect::class)
            // query for the prospect with this id
            ->find($prospectNumber)
        ;

        if (null === $prospect) {
            // causes a validation error
            // this message is not shown to the user
            // see the invalid_message option
            throw new TransformationFailedException(sprintf(
                'A prospect with number "%s" does not exist!',
                $prospectNumber
            ));
        }

        return $prospect;
    }
}