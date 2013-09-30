<?php

/**
 * ClassGeneration
 * Copyright (c) 2012 ClassGeneration
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 * @category   ClassGeneration
 * @package    ClassGeneration
 * @copyright  Copyright (c) 2012 ClassGeneration (https://github.com/tonicospinelli/ClassGeneration)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt    LGPL
 * @version    ##VERSION##, ##DATE##
 */

namespace ClassGeneration\DocBlock;

use ClassGeneration\Collection\CollectionInterface;

/**
 * Tag Collection ClassGeneration
 * @category   ClassGeneration
 * @package    ClassGeneration
 * @copyright  Copyright (c) 2012 ClassGeneration (https://github.com/tonicospinelli/ClassGeneration)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt    LGPL
 * @version    ##VERSION##, ##DATE##
 */
interface TagCollectionInterface extends CollectionInterface
{

    /**
     * Check the tag name is unique on collection.
     *
     * @param string $tagName
     *
     * @return bool
     */
    public function isUniqueTag($tagName);

    /**
     * Removes tag by reference.
     *
     * @param int|string|array $reference
     *
     * @return TagCollectionInterface
     */
    public function removeByReferece($reference);

    /**
     * Removes tags by name.
     *
     * @param string|array $tagName
     *
     * @return TagCollectionInterface
     */
    public function removeByName($tagName);
    /**
     * Get Tag Iterator.
     *
     * @return TagIterator
     */
    public function getIterator();
}