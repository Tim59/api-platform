<?php

namespace AppBundle\Filter;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\AbstractFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\FilterInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use AppBundle\Exception\ApiException;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraints\Uuid;


class CustomFilter extends AbstractFilter 
{


    /**
     * CustomFilter constructor.
     * @param \Doctrine\Common\Persistence\ManagerRegistry $managerRegistry
     * @param RequestStack                                 $requestStack
     * @param \Psr\Log\LoggerInterface                     $logger
     */
    public function __construct($managerRegistry, RequestStack $requestStack, $logger)
    {
        parent::__construct($managerRegistry, $requestStack);
    }

    /**
     * @param QueryBuilder                $queryBuilder
     * @param QueryNameGeneratorInterface $queryNameGenerator
     * @param string                      $resourceClass
     * @param string|null                 $operationName
     * @throws \Exception
     */
    public function apply(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, string $operationName = null)
    {
        $request = $this->requestStack->getCurrentRequest();
        $parameters = array();

        if (null === $request) {
            return;
        }

        $param = $request->query->get('custom');


        if (strpos($param, ',') === false) {
            $parameters = explode(',', $param);
        } else {
            $parameters[0] = $param;
        }


        $rootAlias = $queryBuilder->getRootAliases()[0];

        #Modify the SQL query
        if (count($parameters) > 1) {
            $parameters = explode(',', $parameters[0]);
            $queryBuilder->andWhere($queryBuilder->expr()->in($rootAlias.'.bar', ':parameter_bar'));
            $queryBuilder->setParameter(':parameter_bar', $parameters);
        } else {
            $queryBuilder->andWhere($queryBuilder->expr()->eq($rootAlias.'.bar', ':parameter_bar'));
            $queryBuilder->setParameter(':parameter_bar', $parameters[0]);
        }
    }

      /**
   * @param string $resourceClass
   * @return array
   */
  public function getDescription(string $resourceClass): array
  {
      return [
          'custom' => [
              'property' => null,
              'type' => 'string',
              'required' => false,
              'swagger' => ['description' => 'Example: tes,foo,bar'],
          ],
      ];
  }
  /**
   * Passes a property through the filter.
   *
   * @param string $property
   * @param mixed $value
   * @param QueryBuilder $queryBuilder
   * @param QueryNameGeneratorInterface $queryNameGenerator
   * @param string $resourceClass
   * @param string|null $operationName
   */
  protected function filterProperty(string $property, $value, QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, string $operationName = null)
  {
  }
}
