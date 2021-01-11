<?php declare(strict_types=1);

namespace Kiboko\Plugin\CSV\Builder;

use PhpParser\Builder;
use PhpParser\Node;

final class Extractor implements Builder
{
    private ?Node\Expr $logger;

    public function __construct(
        private Node\Expr $filePath,
        private Node\Expr $delimiter,
        private Node\Expr $enclosure,
        private Node\Expr $escape,
    )
    {
    }

    public function withLogger(Node\Expr $logger): self
    {
        $this->logger = $logger;

        return $this;
    }

    public function getNode(): Node
    {
        return new Node\Expr\New_(
            class: new Node\Name\FullyQualified('Kiboko\\Component\\Flow\\Csv\\Safe\\Extractor'),
            args: [
                new Node\Expr\New_(
                    class: new Node\Name\FullyQualified('SplFileObject'),
                    args: [
                        new Node\Arg($this->filePath),
                        new Node\Arg(new Node\Scalar\String_('r')),
                    ]
                ),
                new Node\Arg($this->delimiter),
                new Node\Arg($this->enclosure),
                new Node\Arg($this->escape),
            ]
        );
    }
}
