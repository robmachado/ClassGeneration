<?php

/**
 * ClassGeneration
 *
 * Copyright (c) 2012 ClassGeneration
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   ClassGeneration
 * @package    ClassGeneration
 * @copyright  Copyright (c) 2012 ClassGeneration (https://github.com/tonicospinelli/ClassGeneration)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt    LGPL
 * @version    ##VERSION##, ##DATE##
 */
namespace ClassGeneration;

use ClassGeneration\Collection\ArrayCollection;

/**
 * Argument Collection ClassGeneration
 *
 * @category   ClassGeneration
 * @package    ClassGeneration
 * @copyright  Copyright (c) 2012 ClassGeneration (https://github.com/tonicospinelli/ClassGeneration)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt    LGPL
 * @version    ##VERSION##, ##DATE##
 */
class ArgumentCollection extends ArrayCollection
{

    /**
     * Add a Argument on collection.<br />
     * The index is a argument name, then will replace
     * if exist a index with the same name.
     *
     * @param Argument|array $argument
     *
     * @return boolean
     */
    public function add($argument)
    {
        if (!$argument instanceof Argument) {
            $argument = new Argument($argument);
        }
        if ($argument->getName() === NULL) {
            $argument->setName('param' . ($this->count() + 1));
        }

        return parent::offsetSet($argument->getName(), $argument);
    }

    /**
     * Gets Argument Iterator
     *
     * @return ArgumentIterator
     */
    public function getIterator()
    {
        return new ArgumentIterator($this);
    }

    /**
     * Returns the arguments in string.
     *
     * @return string
     */
    public function implode()
    {
        $list = $this->getIterator();
        $params = array();
        $optionals = array();
        while ($list->valid()) {
            $item = $list->current();
            if ($item->isOptional()) {
                $optionals[] = $item->toString();
            } else {
                $params[] = $item->toString();
            }
            $list->next();
        }

        return implode(', ', array_merge($params, $optionals));
    }

    /**
     * Removes tags by name.
     *
     * @param $argumentName
     *
     * @return \ClassGeneration\ArgumentCollection
     */
    public function removeByName($argumentName)
    {
        $removedList = new self();
        $list = $this->getIterator();
        foreach ($list as $index => $argument) {
            if ((is_array($argumentName) AND in_array($argument->getName(), $argumentName))
                OR ($argument->getName() === $argumentName)
            ) {
                $removedList->add(clone $argument);
                $this->remove($index);
            }
        }

        return $removedList;
    }
}