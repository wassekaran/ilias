<?php

namespace Igorw\Ilias;

class FormBuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider provideParse
     */
    public function parse($expected, $sexpr)
    {
        $builder = new FormBuilder();
        $form = $builder->parse([$sexpr]);
        $this->assertEquals([$expected], $form);
    }

    public function provideParse()
    {
        return [
            'value'                     => [
                new Form\LiteralForm(2),
                2
            ],
            'simple expression'         => [
                new Form\ListForm([
                    new Form\SymbolForm('+'),
                    new Form\LiteralForm(1),
                    new Form\LiteralForm(2)
                ]),
                ['+', 1, 2]
            ],
            'nested expression'         => [
                new Form\ListForm([
                    new Form\SymbolForm('+'),
                    new Form\LiteralForm(1),
                    new Form\ListForm([
                        new Form\SymbolForm('+'),
                        new Form\LiteralForm(2),
                        new Form\LiteralForm(3)
                    ])
                ]),
                ['+', 1, ['+', 2, 3]]
            ],
            'deeply nested expression'  => [
                new Form\ListForm([
                    new Form\SymbolForm('+'),
                    new Form\LiteralForm(1),
                    new Form\ListForm([
                        new Form\SymbolForm('+'),
                        new Form\LiteralForm(2),
                        new Form\ListForm([
                            new Form\SymbolForm('+'),
                            new Form\LiteralForm(3),
                            new Form\LiteralForm(4),
                            new Form\LiteralForm(5),
                            new Form\LiteralForm(6),
                            new Form\ListForm([
                                new Form\SymbolForm('+'),
                                new Form\LiteralForm(6),
                                new Form\LiteralForm(4),
                                new Form\LiteralForm(3),
                                new Form\LiteralForm(2)
                            ]),
                            new Form\LiteralForm(5),
                            new Form\LiteralForm(1)
                        ]),
                    ])
                ]),
                ['+', 1, ['+', 2, ['+', 3, 4, 5, 6, ['+', 6, 4, 3, 2], 5, 1]]],
            ],
        ];
    }
}
