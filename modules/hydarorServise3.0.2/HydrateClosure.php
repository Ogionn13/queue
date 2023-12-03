<?php
declare(strict_types=1);

namespace PTS\Hydrator;

use Closure;
use function call_user_func_array;
use function is_array;

class HydrateClosure
{

    public function populateClosure(): Closure
    {
        return static function($model, array $dto, array $rules)
        {
            foreach ($dto as $name => $value) {
                $rule = $rules[$name] ?? null;
                if ($rule === null) {
                    continue;
                }

                $setter = $rule['set'] ?? false;
                if (!$setter) {
                    $model->{$rule['prop']} = $value;
                    continue;
                }

                $args = [$value];
                $method = $setter;
                if (is_array($setter)) {
                    [$method, $args] = $setter;
                    array_unshift($args, $value);
                }

                call_user_func_array([$model, $method], $args);
            }

            return $model;
        };
    }
}
