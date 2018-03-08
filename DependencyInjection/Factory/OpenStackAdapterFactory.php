<?php

namespace Knp\Bundle\GaufretteBundle\DependencyInjection\Factory;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\Reference;

/**
 * OpenCloud adapter factory
 *
 * @author Mammino Luciano 2013 <lmammino@oryzone.com>
 */
class OpenStackAdapterFactory implements AdapterFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function create(ContainerBuilder $container, $id, array $config)
    {
        $childDefinition = class_exists('\Symfony\Component\DependencyInjection\ChildDefinition')
            ? new ChildDefinition('knp_gaufrette.adapter.openstack')
            : new DefinitionDecorator('knp_gaufrette.adapter.openstack');

        $container
            ->setDefinition($id, $childDefinition)
            ->replaceArgument(0, new Reference($config['object_store_id']))
            ->replaceArgument(1, $config['container_name'])
            ->replaceArgument(2, $config['create_container'])
        ;
    }

    /**
     * {@inheritDoc}
     */
    public function getKey()
    {
        return 'openstack';
    }

    /**
     * {@inheritDoc}
     */
    public function addConfiguration(NodeDefinition $node)
    {
        $node
        ->children()
            ->scalarNode('object_store_id')->isRequired()->cannotBeEmpty()->end()
            ->scalarNode('container_name')->isRequired()->cannotBeEmpty()->end()
            ->booleanNode('create_container')->defaultFalse()->end()
        ->end()
        ;
    }
}
