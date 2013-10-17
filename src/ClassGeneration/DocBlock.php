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
namespace ClassGeneration;

use ClassGeneration\DocBlock\TagCollection;
use ClassGeneration\DocBlock\TagCollectionInterface;
use ClassGeneration\DocBlock\TagInterface;
use ClassGeneration\Element\ElementAbstract;

/**
 * DocBlock ClassGeneration
 * @category   ClassGeneration
 * @package    ClassGeneration
 * @copyright  Copyright (c) 2012 ClassGeneration (https://github.com/tonicospinelli/ClassGeneration)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt    LGPL
 * @version    ##VERSION##, ##DATE##
 */
class DocBlock extends ElementAbstract implements DocBlockInterface
{

    /**
     * DockBlock description.
     * @var string
     */
    protected $description;

    /**
     * List of allowed tags.
     * @var TagCollectionInterface
     */
    protected $tagCollection;

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        $this->setTagCollection(new TagCollection());
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * {@inheritdoc}
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTagCollection()
    {
        return $this->tagCollection;
    }

    /**
     * {@inheritdoc}
     */
    public function setTagCollection(TagCollectionInterface $tagCollection)
    {
        $this->tagCollection = $tagCollection;

        return $this;
    }

    /**
     * Add a docblock tag.
     *
     * @param TagInterface $tag
     *
     * @return DocBlock
     */
    public function addTag(TagInterface $tag)
    {
        $this->getTagCollection()->add($tag);

        return $this;
    }

    /**
     * Removes tags by name.
     *
     * @param $tagName
     *
     * @return TagCollection
     */
    public function removeTagsByName($tagName)
    {
        return $this->tagCollection->removeByName($tagName);
    }

    /**
     * Removes tags by reference.
     *
     * @param string $reference
     *
     * @return TagCollection
     */
    public function removeTagsByReference($reference)
    {
        return $this->tagCollection->removeByReferece($reference);
    }

    /**
     * Gets tags by name.
     *
     * @param string $nameTag
     *
     * @return TagCollectionInterface
     */
    public function getTagsByName($nameTag)
    {
        $foundList = new TagCollection();
        $list = $this->getTagCollection()->getIterator();

        foreach ($list as $index => $tag) {
            $name = $tag->getName();
            if (is_array($nameTag) and in_array($name, $nameTag)) {
                $foundList->add($this->getTagCollection()->get($index));
            } elseif ($name === $nameTag) {
                $foundList->add($this->getTagCollection()->get($index));
            }
        }

        return $foundList;
    }

    /**
     * @{inheritdoc}
     */
    public function toString()
    {
        if ($this->getTagCollection()->count() == 0
            and ($this->getDescription() === null or $this->getDescription() === '')
        ) {
            return PHP_EOL;
        }

        $spaces = $this->getTabulationFormatted();
        $block = PHP_EOL
            . $spaces . '/**' . PHP_EOL
            . $spaces . ' * ' . $this->getDescription() . PHP_EOL
            . preg_replace('/^ \* /', $spaces . ' * ', $this->getTagCollection()->toString());

        return $block . $spaces . ' */' . PHP_EOL;
    }
}
