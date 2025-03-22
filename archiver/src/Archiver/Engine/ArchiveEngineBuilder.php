<?php

namespace App\Archiver\Engine;

use App\Archiver\DataTypes\Config\ArchiveConfig;
use App\Archiver\Engine\Base\AbstractArchiveEngine;
use Exception;
use Psr\Log\LoggerAwareTrait;

class ArchiveEngineBuilder
{
    use LoggerAwareTrait;
    private AbstractArchiveEngine $engine;
    private bool $isForce = false;

    public function __construct(
        protected readonly ArchiveConfig $config
    ) {
    }

    /**
     * Build object
     * @return $this
     * @throws Exception
     */
    public function build() : self
    {
        $this->engine = $this->makeEngineObject();

        $this->engine->setIsForce($this->isForce);
        $this->engine->setLogger($this->logger);

        return $this;
    }

    /**
     * @return AbstractArchiveEngine
     */
    public function getEngine() : AbstractArchiveEngine {
        return $this->engine;
    }

    /**
     * @param bool $isForce
     * @return $this
     */
    public function setForce(bool $isForce) : self {
        $this->isForce = $isForce;

        return $this;
    }

    /**
     * Create ArchiveEngineBuilder instance
     * @return AbstractArchiveEngine
     * @throws Exception
     */
    private function makeEngineObject() : AbstractArchiveEngine {
        $engineClass = __NAMESPACE__ . '\\Engine\\' . ucfirst(strtolower($this->config->type));

        if (is_subclass_of($engineClass, AbstractArchiveEngine::class)) {
            return new $engineClass($this->config);
        }

        throw new Exception('Class: ' . $engineClass . ' doesn\'t instance of ' . AbstractArchiveEngine::class);
    }
}