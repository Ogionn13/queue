<?php
declare(strict_types=1);

namespace PTS\Hydrator;

class HydratorService implements HydratorInterface, ExtractorInterface
{
    /** @var Extractor */
    protected $extractor;
    /** @var Hydrator */
    protected $hydrator;
    /** @var Normalizer|null */
    protected $normalizer;

    public function __construct(
        Extractor $extractor = null,
        Hydrator $hydrator = null
    ) {
        $this->extractor = $extractor ?? new Extractor;
        $this->hydrator = $hydrator ?? new Hydrator;
    }

    public function hydrate(array $dto, string $class, array $rules)
    {
        return $this->hydrator->hydrate($dto, $class, $rules);
    }

    public function hydrateModel(array $dto, object $model, array $rules): void
    {
        $this->hydrator->hydrateModel($dto, $model, $rules);
    }

    public function extract(object $model, array $rules): array
    {
        return $this->extractor->extract($model, $rules);
    }

    public function getHydrator(): HydratorInterface
    {
        return $this->hydrator;
    }

    public function getExtractor(): ExtractorInterface
    {
        return $this->extractor;
    }
}
