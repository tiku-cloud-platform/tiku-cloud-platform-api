<?php
declare(strict_types=1);

namespace App\Listener;

use Hyperf\Event\Contract\ListenerInterface;
use Hyperf\Validation\Contract\ValidatorFactoryInterface;
use Hyperf\Validation\Event\ValidatorFactoryResolved;

/**
 * 邮箱验证
 */
class ValidatorEmailFactoryResolvedListener implements ListenerInterface
{
	public function listen(): array
	{
		return [
			ValidatorFactoryResolved::class
		];
	}

	public function process(object $event)
	{
		/** @var ValidatorFactoryInterface $validatorFactory */
		$validatorFactory = $event->validatorFactory;
		$validatorFactory->extend('email', function ($attribute, $value, $parameters, $validator) {
			if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
                return true;
            }
            return false;
		});
		$validatorFactory->replacer('email', function ($message, $attribute, $rule, $parameters) {
			return str_replace(':email', $attribute, $message);
		});
	}
}