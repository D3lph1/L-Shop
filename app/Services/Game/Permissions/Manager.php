<?php
declare(strict_types = 1);

namespace App\Services\Game\Permissions;

use App\Services\Game\Permissions\Predicates\FilterPermissionsPredicate;
use App\Services\Game\Permissions\Predicates\Regex;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Manager
{
    public function filterPermissions(FilterPermissionsPredicate $predicate)
    {
        $result = new ArrayCollection();

        foreach (($predicate->getPlayer()->getPermissions()->filter(function (Permission $each) use ($predicate) {
            return $this->filter($each, $predicate);
        })) as $item) {
            $result->add($item);
        }

        $this->throughGroup($predicate->getPlayer()->getPrimaryGroup(), $predicate, $result);

        $predicate->getPlayer()->getGroups()->forAll(function (int $index, Group $group) use ($predicate, $result) {
            $this->throughGroup($group, $predicate, $result);
        });

        dd($result);
    }

    private function filter(Permission $each, FilterPermissionsPredicate $predicate):bool
    {
        if (
            ($predicate->getPermission() instanceof Regex && preg_match($predicate->getPermission()->getRegex(), $each->getName())) ||
            ($each->getName() === $predicate->getPermission()))
        {
            if (!$predicate->needAnyServer()) {
                if ($predicate->getServer() !== null) {
                    if ($each->getServer()->getId() !== $predicate->getServer()->getId()) {
                        return false;
                    }
                } else {
                    if ($each->getServer() !== $predicate->getServer()) {
                        return false;
                    }
                }
            }

            if ($each->getWorld() !== $predicate->getWorld()) {
                return false;
            }

            if ($predicate->needAllowed() !== null) {
                if ($predicate->needAllowed()) {
                    if (!$each->isAllowed()) {
                        return false;
                    }
                } else {
                    if ($each->isAllowed()) {
                        return false;
                    }
                }
            }

            if ($predicate->getContexts() !== null) {
                if ($each->getContexts() !== $predicate->getContexts()) {
                    return false;
                }
            }

            return true;
        }

        return false;
    }

    private function throughGroup(Group $group, FilterPermissionsPredicate $predicate, Collection $result)
    {
        foreach (($group->getPermissions()->filter(function (Permission $each) use ($predicate) {
            return $this->filter($each, $predicate);
        })) as $item) {
            $result->add($item);
        }

        $group->getParents()->forAll(function (int $index, Group $eachGroup) use ($predicate, $result) {
            $this->throughGroup($eachGroup, $predicate, $result);
        });
    }
}
