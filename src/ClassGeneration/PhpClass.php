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

use ClassGeneration\DocBlock\Tag;
use ClassGeneration\DocBlock\TagInterface;
use ClassGeneration\Element\Declarable;
use ClassGeneration\Element\Documentary;
use ClassGeneration\Element\ElementAbstract;

/**
 * @category   ClassGeneration
 * @package    ClassGeneration
 * @copyright  Copyright (c) 2012 ClassGeneration (https://github.com/tonicospinelli/ClassGeneration)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt    LGPL
 * @version    ##VERSION##, ##DATE##
 */
class PhpClass extends ElementAbstract implements PhpClassInterface, Documentary, Declarable
{

    /**
     * Sets like a trait.
     * @var boolean
     */
    protected $isTrait = false;

    /**
     * Sets like an interface.
     * @var boolean
     */
    protected $isInterface = false;

    /**
     * Set like a final.
     * @var bool
     */
    protected $isFinal = false;

    /**
     * Set like an abstract.
     * @var bool
     */
    protected $isAbstract = false;

    /**
     * Documentation Block
     * @var DocBlockInterface
     */
    protected $docBlock;

    /**
     * Class name
     * @var string
     */
    protected $name;

    /**
     * Class namespace
     * @var NamespaceClass
     */
    protected $namespace;

    /**
     * Class Use Collection
     * @var UseCollection
     */
    protected $useCollection;

    /**
     * Class constants
     * @var ConstantCollection
     */
    protected $constants;

    /**
     * Class properties
     * @var PropertyCollection
     */
    protected $properties;

    /**
     * Class methods
     * @var MethodCollection
     */
    protected $methods;

    /**
     * Extends from.
     * @var string
     */
    protected $extends;

    /**
     * Implements the interfaces.
     * @var InterfaceCollection
     */
    protected $interfaces;

    /**
     * Force on add method on class docblock.
     * @var boolean
     */
    public $forceMethodInDocBlock = false;

    /**
     * Force on add property on class docblock.
     * @var boolean
     */
    public $forcePropertyInDocBlock = false;

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        $this->setTabulation(0);
        $this->setDocBlock(new DocBlock());
        $this->setMethodCollection(new MethodCollection());
        $this->setPropertyCollection(new PropertyCollection());
        $this->setConstantCollection(new ConstantCollection());
        $this->setInterfaceCollection(new InterfaceCollection());
        $this->setNamespace(new NamespaceClass());
        $this->setUseCollection(new UseCollection());
    }

    /**
     * {@inheritdoc}
     */
    public function getDocBlock()
    {
        return $this->docBlock;
    }

    /**
     * {@inheritdoc}
     */
    public function setDocBlock(DocBlockInterface $docBlock)
    {
        $this->docBlock = $docBlock;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getFullName()
    {
        return $this->getNamespace()->getPath() . '\\' . $this->getName();
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @inheritdoc
     */
    public function setName($name)
    {
        $replaceTo = strpos($name, '_') !== false ? '_' : '';
        $this->name = str_replace(' ', $replaceTo, ucwords(strtr($name, '_-', '  ')));
        $this->addCommentTag(
            new Tag(
                array(
                    'name'        => Tag::TAG_NAME,
                    'description' => $this->name
                )
            )
        );

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * @inheritdoc
     */
    public function setNamespace(NamespaceInterface $namespace)
    {
        $namespace->setParent($this);
        $this->namespace = $namespace;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getConstantCollection()
    {
        return $this->constants;
    }

    /**
     * @inheritdoc
     */
    public function setConstantCollection(ConstantCollection $constants)
    {
        $this->constants = $constants;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function addConstant(ConstantInterface $const)
    {
        $const->setParent($this);
        $this->getConstantCollection()->add($const);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getPropertyCollection()
    {
        return $this->properties;
    }

    /**
     * @inheritdoc
     */
    public function getProperty($propertyName)
    {
        return $this->properties->getByName($propertyName);
    }

    /**
     * @inheritdoc
     */
    public function setPropertyCollection(PropertyCollection $properties)
    {
        $this->properties = $properties;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function addProperty(PropertyInterface $property)
    {
        $property->setParent($this);
        $this->getPropertyCollection()->add($property);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function addCommentTag(TagInterface $tagArguments)
    {
        $this->getDocBlock()->addTag($tagArguments);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getMethodCollection()
    {
        return $this->methods;
    }

    /**
     * @inheritdoc
     */
    public function addMethod(MethodInterface $method)
    {
        $method->setParent($this);
        $this->getMethodCollection()->add($method);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setMethodCollection(MethodCollection $methods)
    {
        $this->methods = $methods;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getExtends()
    {
        return $this->extends;
    }

    /**
     * @inheritdoc
     */
    public function setExtends($extends)
    {
        $this->extends = $extends;
        if (class_exists($extends)) {
            $refExtends = new \ReflectionClass($extends);
            $methods = $refExtends->getMethods();
            foreach ($methods as $method) {
                if ($method->isAbstract()) {
                    $this->addMethod(new Method(array('name' => $method->getName())));
                }
            }
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getInterfaceCollection()
    {
        return $this->interfaces;
    }

    /**
     * @inheritdoc
     */
    public function addInterface($interfaceName)
    {
        $this->interfaces->add($interfaceName);

        if (interface_exists($interfaceName)) {
            $refInterface = new \ReflectionClass($interfaceName);
            $methods = $refInterface->getMethods();
            foreach ($methods as $method) {
                $this->addMethod(new Method(array('name' => $method->getName())));
            }
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setInterfaceCollection(InterfaceCollection $interfacesNames)
    {
        $this->interfaces = $interfacesNames;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function isTrait()
    {
        return $this->isTrait;
    }

    /**
     * @inheritdoc
     */
    public function setIsTrait($isTrait = true)
    {
        $this->isTrait = (bool)$isTrait;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function isInterface()
    {
        return $this->isInterface;
    }

    /**
     * @inheritdoc
     */
    public function setIsInterface($isInterface = true)
    {
        if ($this->isAbstract()) {
            throw new \RuntimeException('This method is an abstract and it not be an interface too.');
        }

        $this->isInterface = (bool)$isInterface;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setDescription($description)
    {
        $this->docBlock->setDescription($description);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getUseCollection()
    {
        return $this->useCollection;
    }

    /**
     * @inheritdoc
     */
    public function addUse(UseInterface $use)
    {
        $this->useCollection->add($use);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setUseCollection(UseCollection $uses)
    {
        $this->useCollection = $uses;

        return $this;
    }

    /**
     * Create a Get Method from Property of Class.
     *
     * @param PropertyInterface $property
     *
     * @return void
     */
    protected function generateGetterFromProperty(PropertyInterface $property)
    {
        $this->addMethod(
            new Method(
                array(
                    'name' => 'get_' . $property->getName(),
                    'code' => 'return $this->' . $property->getName() . ';'
                )
            )
        );
    }

    /**
     * Generate Set Method from Property.
     * Add a set method in the class based on Object Property.
     *
     * @param PropertyInterface $property
     *
     * @return void
     */
    protected function generateSetterFromProperty(PropertyInterface $property)
    {
        $argument = new Argument(
            array(
                'name' => $property->getName(),
                'type' => $property->getType()
            )
        );
        $code = "\$this->{$property->getName()} = {$argument->getNameFormatted()};"
            . PHP_EOL
            . 'return $this;';
        $this->addMethod(
            new Method(
                array(
                    'name'               => 'set_' . $property->getName(),
                    'argumentCollection' => new ArgumentCollection(array($argument)),
                    'code'               => $code
                )
            )
        );
    }

    /**
     * Create all getters and setters from Property Collection.
     * @return void
     */
    public function generateGettersAndSettersFromProperties()
    {
        $propertyIterator = $this->getPropertyCollection()->getIterator();
        foreach ($propertyIterator as $property) {
            $this->generateGetterFromProperty($property);
            $this->generateSetterFromProperty($property);
        }
    }

    /**
     * @inheritdoc
     */
    public function toString()
    {
        $extends = '';

        if ($this->isInterface()) {
            $type = 'interface ';
        } elseif ($this->isAbstract()) {
            $type = 'abstract class ';
        } elseif ($this->isFinal()) {
            $type = 'final class ';
        } elseif ($this->isTrait()) {
            $type = 'trait ';
        } else {
            $type = 'class ';
        }

        if ($this->getExtends()) {
            $extends = ' extends ' . $this->getExtends();
        }
        $string = '<?php' . PHP_EOL
            . $this->getNamespace()->toString()
            . $this->getUseCollection()->toString()
            . $this->getDocBlock()->setTabulation($this->getTabulation())->toString()
            . $type
            . $this->getName()
            . $extends
            . $this->getInterfaceCollection()->toString()
            . PHP_EOL
            . '{'
            . PHP_EOL
            . $this->getConstantCollection()->toString()
            . $this->getPropertyCollection()->toString()
            . $this->getMethodCollection()->toString()
            . '}' . PHP_EOL;

        return $string;
    }

    /**
     * Saves the class on file.
     *
     * @param string      $directoryPath
     * @param string|null $fileName
     * @param boolean     $overwrite If exists the file, overwrite it.
     *
     * @throws \Exception
     */
    public function save($directoryPath, $fileName = null, $overwrite = false)
    {
        if (!is_dir($directoryPath)) {
            throw new \Exception('This directory ' . $directoryPath . ' not found');
        }
        if (is_null($fileName)) {
            $fileName = $this->getName();
        }

        $directoryPath = realpath($directoryPath);
        $directoryPath .= DIRECTORY_SEPARATOR
            . str_replace('\\', DIRECTORY_SEPARATOR, $this->getNamespace()->getPath());
        $path = explode(DIRECTORY_SEPARATOR, $directoryPath);
        $dirPath = '';
        foreach ($path as $pathName) {
            $dirPath .= $pathName . DIRECTORY_SEPARATOR;
            if (!is_dir($dirPath)) {
                mkdir($dirPath);
            }
        }
        $fullFileName = $dirPath . $fileName . '.php';
        if ($overwrite || !is_file($fullFileName)) {
            $file = new \SplFileObject($fullFileName, 'w');
            $file->fwrite($this->toString());
        }
    }

    /**
     * @inheritdoc
     */
    public function evaluate()
    {
        $classString = substr($this->toString(), 7);
        eval($classString);
    }

    /**
     * {@inheritdoc}
     */
    public function isFinal()
    {
        return $this->isFinal;
    }

    /**
     * {@inheritdoc}
     * @return PhpClass
     */
    public function setIsFinal($isFinal = true)
    {
        $this->isFinal = (bool)$isFinal;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isAbstract()
    {
        return $this->isAbstract;
    }

    /**
     * {@inheritdoc}
     *
     */
    public function setIsAbstract($isAbstract = true)
    {
        if ($this->isInterface()) {
            throw new \RuntimeException('This method is an interface and it not be an abstract too.');
        }

        $this->isAbstract = (bool)$isAbstract;
    }
}