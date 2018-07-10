<?php
declare(strict_types = 1);

namespace App\Services\Game\Permissions;

use App\Services\Game\Permissions\Predicates\PermissionPredicate;
use App\Services\Game\Permissions\Predicates\Regex;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Funnel
{
    /**
     * It is used to prevent the processing of privileges of an already processed group.
     * This approach prevents duplication of permissions in the resulting set.
     *
     * @var array
     */
    private $processed = [];

    public function filterPlayerPermissions(Player $player, PermissionPredicate $predicate): Collection
    {
        $this->processed = [];
        $result = new ArrayCollection();

        foreach (($player->getPermissions()->filter(function (Permission $each) use ($predicate) {
            return $this->filter($each, $predicate);
        })) as $item) {
            $result->add($item);
        }

        $this->throughGroup($player->getPrimaryGroup(), $predicate, $result);
        $player->getGroups()->forAll(function (int $index, Group $group) use ($predicate, $result) {
            $this->throughGroup($group, $predicate, $result);

            return true;
        });

        return $result;
    }

    public function filterGroupPermissions(Group $group, PermissionPredicate $predicate): Collection
    {
        $this->processed = [];
        $result = new ArrayCollection();
        $this->throughGroup($group, $predicate, $result);

        return $result;
    }

    private function filter(Permission $each, PermissionPredicate $predicate): bool
    {
        if ($predicate->getPermission() !== null && (
                (
                    $predicate->getPermission() instanceof Regex &&
                    preg_match($predicate->getPermission()->getRegex(), $each->getName()) === 0
                )
                || (is_string($predicate->getPermission()) && $each->getName() !== $predicate->getPermission())
            ))
        {
            return false;
        }

        if (!$predicate->needAnyServer()) {
            // Non strict equals because $predicate->getServer() may has any type.
            if ($each->getServer() != $predicate->getServer()) {
                return false;
            }
        }

        if (!$predicate->needAnyWorld()) {
            if ($each->getWorld() !== $predicate->getWorld()) {
                return false;
            }
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

        if (!$predicate->needAnyContexts()) {
            if ($each->getContexts() !== $predicate->getContexts()) {
                return false;
            }
        }

        return true;
    }

    private function throughGroup(Group $group, PermissionPredicate $predicate, Collection $result)
    {
        // Prevent the processing of permissions of an already processed group.
        if (!in_array($group->getName(), $this->processed)) {
            $this->processed[] = $group->getName();
            foreach (($group->getPermissions()->filter(function (Permission $each) use ($predicate) {
                return $this->filter($each, $predicate);
            })) as $item) {
                $result->add($item);
            }
        }

        $group->getParents()->forAll(function (int $index, Group $eachGroup) use ($predicate, $result) {
            $this->throughGroup($eachGroup, $predicate, $result);
        });
    }
}
