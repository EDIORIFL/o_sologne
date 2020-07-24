<?php 
namespace App\Form\DataTransformer;

use App\Entity\Support;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class SupportToNumberTransformer implements DataTransformerInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Transforms an object (support) to a string (number).
     *
     * @param  Support|null $support
     * @return string
     */
    public function transform($support)
    {
        // dd($support);
        if (null === $support) {
            return '';
        }

        return $support->getId();
    }

    /**
     * Transforms a string (number) to an object (support).
     *
     * @param  string $supportNumber
     * @return Support|null
     * @throws TransformationFailedException if object (support) is not found.
     */
    public function reverseTransform($supportNumber)
    {
        // no support number? It's optional, so that's ok
        if (!$supportNumber) {
            return;
        }

        $support = $this->entityManager
            ->getRepository(Support::class)
            // query for the support with this id
            ->find($supportNumber)
        ;

        if (null === $support) {
            // causes a validation error
            // this message is not shown to the user
            // see the invalid_message option
            throw new TransformationFailedException(sprintf(
                'A support with number "%s" does not exist!',
                $supportNumber
            ));
        }

        return $support;
    }
}