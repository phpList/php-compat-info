<?php

namespace Bartlett\CompatInfo\Sniffs\PHP;

use Bartlett\CompatInfoDb\Environment;
use Bartlett\CompatInfo\Collection\ReferenceCollection;

use Bartlett\Reflect\Sniffer\SniffAbstract;

use PhpParser\Node;

use PDO;

/**
 *
 */
class NoCompatCallFromGlobalSniff extends SniffAbstract
{
    private $noCompat;
    private $references;

    public function setUpBeforeSniff()
    {
        parent::setUpBeforeSniff();

        /**
         * Initializes CompatInfo DB
         */
        $pdo = Environment::initRefDb();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $this->references = new ReferenceCollection(array(), $pdo);

        // @TODO reintegrate in ReferenceCollection CTOR
        $elements = array(
            'func_get_arg',
            'func_get_args',
            'func_num_args',
        );
        foreach ($elements as $name) {
            $this->references->find('functions', $name);
        }

        $this->noCompat = array();
    }

    public function leaveSniff()
    {
        parent::leaveSniff();

        if (!empty($this->noCompat)) {
            // inform analyser that few sniffs were found
            $this->visitor->setMetrics(
                array(Metrics::NO_COMPAT_CALL => $this->noCompat)
            );
        }
    }

    public function enterNode(Node $node)
    {
        if ($node instanceof Node\Expr\FuncCall
            && $node->name instanceof Node\Name
            && $this->references->containsKey((string) $node->name)
            && !$this->visitor->inContext('method')
            && !$this->visitor->inContext('function')
        ) {
            $name = (string) $node->name;
            $message = sprintf(
                'No function context for <info>%s()</info> called from the global scope',
                $name
            );
            $versions = $this->references->get($name);
            $version  = $versions['php.min'];
            $severity = $this->getCurrentSeverity($version, 'lt', 'warning');

            if (!isset($this->noCompat[$name])) {
                $this->noCompat[$name] = array(
                    'severity' => $severity,
                    'version'  => $version,
                    'message'  => $message,
                    'spots'    => array()
                );
            }
            $this->noCompat[$name]['spots'][] = $this->getCurrentSpot($node);
        }
    }
}
