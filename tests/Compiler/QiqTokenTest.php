<?php
declare(strict_types=1);

namespace Qiq\Compiler;

class QiqTokenTest extends \PHPUnit\Framework\TestCase
{
    protected function assertPhp(string $php, string $qiq) : void
    {
        $token = QiqToken::new($qiq);
        $this->assertSame($php, (string) $token);
    }

    public function testBadToken() : void
    {
        $this->assertNull(QiqToken::new('{ not a token }'));
    }

    /**
     * @dataProvider provideEcho
     */
    public function testEcho_none(string $str) : void
    {
        // typical
        $qiq = "{{ {$str} }}";
        $php = "<?php {$str} ?>";
        $this->assertPhp($php, $qiq);

        // no space in tags
        $qiq = "{{" . $str . "}}";
        $php = "<?php {$str} ?>";
        $this->assertPhp($php, $qiq);

        // with newlines
        $qiq = "{{" . PHP_EOL . "    {$str}" . PHP_EOL . "}}";
        $php = "<?php" . PHP_EOL . "    {$str}" . PHP_EOL . "?>";
        $this->assertPhp($php, $qiq);
    }

    /**
     * @dataProvider provideEcho
     */
    public function testEcho_raw(string $str) : void
    {
        // typical
        $qiq = "{{= {$str} }}";
        $php = "<?= {$str} ?>";
        $this->assertPhp($php, $qiq);

        // space around =
        $qiq = "{{ = {$str} }}";
        $php = "<?= {$str} ?>";
        $this->assertPhp($php, $qiq);

        // with newline after
        $qiq = "{{= {$str} }}" . PHP_EOL;
        $php = "<?= {$str} ?><?= PHP_EOL ?>" . PHP_EOL;
        $this->assertPhp($php, $qiq);

        // with newline in tags
        $qiq = "{{=" . PHP_EOL . "    {$str}" . PHP_EOL . "}}";
        $php = "<?=" . PHP_EOL . "    {$str}" . PHP_EOL . "?>";
        $this->assertPhp($php, $qiq);

        // with indenting and newline
        $qiq = "    {{=" . PHP_EOL . "        {$str}" . PHP_EOL . "    }}";
        $php = "    <?=" . PHP_EOL . "        {$str}" . PHP_EOL . "    ?>";
        $this->assertPhp($php, $qiq);
    }

    /**
     * @dataProvider provideEcho
     */
    public function testEcho_escaped(string $str) : void
    {
        foreach (['a', 'c', 'h', 'j', 'u'] as $esc) {
            // typical
            $qiq = "{{{$esc} {$str} }}";
            $php = "<?= \$this->{$esc}({$str}) ?>";
            $this->assertPhp($php, $qiq);

            // extra leading and trailing space
            $qiq = "{{ {$esc} {$str} }}";
            $php = "<?= \$this->{$esc}({$str}) ?>";
            $this->assertPhp($php, $qiq);

            // no trailing space
            $qiq = "{{{$esc} {$str}}}";
            $php = "<?= \$this->{$esc}({$str}) ?>";
            $this->assertPhp($php, $qiq);

            // extra leading space
            $qiq = "{{ {$esc} {$str}}}";
            $php = "<?= \$this->{$esc}({$str}) ?>";
            $this->assertPhp($php, $qiq);

            // newlines
            $qiq = "{{{$esc}" . PHP_EOL . "    {$str}" . PHP_EOL . "}}";
            $php = "<?= \$this->{$esc}(" . PHP_EOL . "    {$str}" . PHP_EOL . ") ?>";
            $this->assertPhp($php, $qiq);

            // indent and newlines
            $qiq = "    {{{$esc}" . PHP_EOL . "        {$str}" . PHP_EOL . "    }}";
            $php = "    <?= \$this->{$esc}("
                . PHP_EOL
                . "        {$str}"
                . PHP_EOL
                . "    ) ?>";
            $this->assertPhp($php, $qiq);
        }
    }

    /**
     * @return mixed[]
     */
    public static function provideEcho() : array
    {
        return [
            ["'foo bar'"],
            ['"foo bar"'],
            ['$foo["bar"]'],
            ['123 + 456'],
            ['(123 + 456)'],
            ['-123 +456'],
            ['["foo" => "bar"]'],
            ['__FILE__'],
            ['__LINE__'],
            ['__DIR__'],
            ['true'],
            ['false'],
            ['null'],
            ['PHP_VERSION'],
            ['/* comment */'],
        ];
    }

    /**
     * @dataProvider provideKnown
     */
    public function testKnown(string $code) : void
    {
        // typical
        $qiq = "{{ {$code} }}";
        $php = "<?php {$code} ?>";
        $this->assertPhp($php, $qiq);

        // leading newline
        $qiq = "{{~ {$code} }}";
        $php = "<?= PHP_EOL ?><?php {$code} ?>";
        $this->assertPhp($php, $qiq);

        // indent and newlin
        $qiq = "    {{" . PHP_EOL . "        {$code}" . PHP_EOL . "    }}";
        $php = "    <?php" . PHP_EOL . "        {$code}" . PHP_EOL . "    ?>";
        $this->assertPhp($php, $qiq);
    }

    /**
     * @return mixed[]
     */
    public static function provideKnown() : array
    {
        return [
            ['if ($foo):'],
            ['elseif ($bar):'],
            ['else'],
            ['endif'],
            ['for ($i = 0; $i <= $k; $i ++):'],
            ['endfor'],
            ['foreach ($foo as $bar => $baz):'],
            ['endforeach'],
            ['while ($foo):'],
            ['endwhile'],
            ['break'],
            ['continue'],
            ['isset($foo) ? "this" : "that"'],
            ['empty($foo) ? "this" : "that"'],
            ['list ($foo, $bar) = $baz'],
            ['namespace NsName'],
            ['use ClassName'],
        ];
    }

    public function testHelper() : void
    {
        // typical
        $qiq = '{{= textField(["name" => "street", "value" => $street]) }}';
        $php = '<?= $this->textField(["name" => "street", "value" => $street]) ?>';
        $this->assertPhp($php, $qiq);

        // newlines
        $qiq = <<<'QIQ'
        {{= textField([
            "name" => "street", "value" => $street
        ]) }}
        QIQ;
        $php = <<<'PHP'
        <?= $this->textField([
            "name" => "street", "value" => $street
        ]) ?>
        PHP;
        $this->assertPhp($php, $qiq);

        // no params
        $qiq = '{{= helper() }}';
        $php = '<?= $this->helper() ?>';
        $this->assertPhp($php, $qiq);

        // global function
        $qiq = '{{= \strtoupper("foo") }}';
        $php = '<?= \strtoupper("foo") ?>';
        $this->assertPhp($php, $qiq);

        // constant
        $qiq = '{{= Foo::BAR }}';
        $php = '<?= Foo::BAR ?>';
        $this->assertPhp($php, $qiq);

        // static method
        $qiq = '{{= Foo::bar() }}';
        $php = '<?= Foo::bar() ?>';
        $this->assertPhp($php, $qiq);

        // arrow function
        $qiq = '{{ $fn = function () { }; }}';
        $php = '<?php $fn = function () { }; ?>';
        $this->assertPhp($php, $qiq);

        // closure
        $qiq = '{{ function foo() { } }}';
        $php = '<?php function foo() { } ?>';
        $this->assertPhp($php, $qiq);

        // assignment with $this
        $qiq = '{{ $a = $this->anchor("http://example.net") }}';
        $php = '<?php $a = $this->anchor("http://example.net") ?>';
        $this->assertPhp($php, $qiq);

        // assignment without $this
        $qiq = '{{ $a = anchor("http://example.net") }}';
        $php = '<?php $a = $this->anchor("http://example.net") ?>';
        $this->assertPhp($php, $qiq);
    }

    public function testIndenting() : void
    {
        // non-echoing
        $qiq = PHP_EOL . '    {{ if (true): endif; }}';
        $php = PHP_EOL . '    <?php if (true): endif; ?>';
        $this->assertPhp($php, $qiq);

        // echoing
        $set = PHP_OS_FAMILY === 'Windows' ? '\r\n' : '\n';
        $qiq = PHP_EOL
            . '    {{= textField(["name" => "street", "value" => $street]) }}';
        $php = PHP_EOL
            . '    <?php $this->setIndent("'
            . $set
            . '    ") ?><?= $this->textField(["name" => "street", "value" => $street]) ?>';
        $this->assertPhp($php, $qiq);
    }

    public function testNewlineControl() : void
    {
        // echoing, honor trailing newline
        $qiq = '{{= $noop }}' . PHP_EOL;
        $php = '<?= $noop ?><?= PHP_EOL ?>' . PHP_EOL;
        $this->assertPhp($php, $qiq);

        // echoing, consume trailing newline
        $qiq = '{{= $noop ~}}' . PHP_EOL;
        $php = '<?= $noop ?>' . PHP_EOL;
        $this->assertPhp($php, $qiq);

        // non-echoing, consume trailing newline
        $qiq = '{{ $noop }}' . PHP_EOL;
        $php = '<?php $noop ?>' . PHP_EOL;
        $this->assertPhp($php, $qiq);

        // non-echoing, consume trailing newline
        $qiq = '{{ $noop ~}}' . PHP_EOL;
        $php = '<?php $noop ?>' . PHP_EOL;
        $this->assertPhp($php, $qiq);

        // non-echoing, add leading newline
        $qiq = '{{~ $noop }}' . PHP_EOL;
        $php = '<?= PHP_EOL ?><?php $noop ?>' . PHP_EOL;
        $this->assertPhp($php, $qiq);
    }
}
