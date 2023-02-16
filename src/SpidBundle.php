<?php

namespace Links\Bundle\SpidBundle;

use Symfony\Component\Config\Definition\Configurator\DefinitionConfigurator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class SpidBundle extends AbstractBundle
{
    protected string $extensionAlias = 'spid';

    public function configure(DefinitionConfigurator $definition): void
    {
//        // loads config definition from a file
//        $definition->import('../config/definition.php');
//
//        // loads config definition from multiple files (when it's too long you can split it)
//        $definition->import('../config/definition/*.php');

        // if the configuration is short, consider adding it in this class
        $definition->rootNode()
            ->children()
            ->arrayNode('sp')->children()
            ->scalarNode('enabled')->isRequired()->cannotBeEmpty()->end()
            ->scalarNode('entityId')->isRequired()->cannotBeEmpty()->end()
            ->scalarNode('key_file')->isRequired()->cannotBeEmpty()->end()
            ->scalarNode('cert_file')->isRequired()->cannotBeEmpty()->end()
            ->arrayNode('attribute_consuming_service')->isRequired()->arrayPrototype()->requiresAtLeastOneElement()->scalarPrototype()->end()->end()->requiresAtLeastOneElement()->end()
            ->arrayNode('assertion_consumer_service')->isRequired()->scalarPrototype()->end()->requiresAtLeastOneElement()->end()
            ->arrayNode('single_logout_service')->isRequired()->cannotBeEmpty()
            ->arrayPrototype()->requiresAtLeastOneElement()
            ->scalarPrototype()->end()->end()->requiresAtLeastOneElement()
            ->end()
            ->scalarNode('org_name')->isRequired()->cannotBeEmpty()->end()
            ->scalarNode('org_display_name')->isRequired()->cannotBeEmpty()->end()
            ->scalarNode('idp_metadata_folder')->isRequired()->cannotBeEmpty()->end()
            ->arrayNode('sp_key_cert_values')->arrayPrototype()
            ->children()
            ->scalarNode('countryName')->isRequired()->cannotBeEmpty()->end()
            ->scalarNode('stateOrProvinceName')->isRequired()->cannotBeEmpty()->end()
            ->scalarNode('localityName')->isRequired()->cannotBeEmpty()->end()
            ->scalarNode('commonName')->isRequired()->cannotBeEmpty()->end()
            ->scalarNode('emailAddress')->isRequired()->cannotBeEmpty()->end()
            ->end();
    }

    // $config is the bundle Configuration that you usually process in
    // ExtensionInterface::load() but already merged and processed
    public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        // load an XML, PHP or Yaml file
        $container->import('../config/services.xml');

        // you can also add or replace parameters and services
//        $container->parameters()
//            //->set('spid.sp.use_acme_goodbye', $config['use_acme_goodbye'])
//            ->set('spid.sp.enabled', $config['sp']['enabled'])
//            ->set('spid.sp.entityId', $config['sp']['entityId'])
//            ->set('spid.sp.key_file', $config['sp']['key_file'])
//            ->set('spid.sp.cert_file', $config['sp']['cert_file'])
//            ->set('spid.sp.attribute_consuming_service', $config['sp']['attribute_consuming_service'])
//            ->set('spid.sp.', $config['sp'][''])
//            ->set('spid.sp.', $config['sp']['']);

        foreach ($config as $key => $value) {
            $container->parameters()->set('spid.' . $key, $value);
        }

//        if ($config['scream']) {
//            $container->services()
//                ->get('acme_hello.printer')
//                ->class(ScreamingPrinter::class)
//            ;
//        }
    }
}
