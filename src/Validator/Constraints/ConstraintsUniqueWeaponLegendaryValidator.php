<?php

namespace App\Validator\Constraints;

use App\Entity\GameUser;
use App\Entity\User;
use App\Entity\Weapon;
use App\Repository\GameUserRepository;
use App\Repository\WeaponRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class ConstraintsUniqueWeaponLegendaryValidator extends ConstraintValidator
{
    private $weaponRepository;

    public function __construct(WeaponRepository $weaponRepository)
    {
        $this->weaponRepository = $weaponRepository;
    }

    public function validate($weapon, Constraint $constraint)
    {
        if(!$constraint instanceof ConstraintsUniqueWeaponLegendary){
            throw new UnexpectedTypeException($constraint, ConstraintsUniqueWeaponLegendary::class);
        }

        if($weapon->getGameUser() instanceof GameUser && $weapon->getScarcity() === 8){
            $exist = $this->weaponRepository->findOneBy(['GameUser' => $weapon->getGameUser(), 'scarcity' => 8]);

            if($exist instanceof Weapon){
                if($weapon->getId() !== $exist->getId()){
                    $this->context->buildViolation($constraint->message)
                        ->setParameter('{{ username }}', $exist->getGameUser()->getUser()->getUsername())
                        ->addViolation();
                }
            }
        }
    }

}
