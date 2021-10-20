<?php
namespace Qiq\Compiler;

class QiqTokenTest extends \PHPUnit\Framework\TestCase
{
    protected function assertPhp(string $php, string $qiq)
    {
        $token = QiqToken::new($qiq);
        $this->assertSame($php, (string) $token);
    }

    public function testBadToken()
    {
        $this->assertNull(QiqToken::new('{ not a token }'));
    }

    /**
     * @dataProvider echoProvider
     */
    public function testEcho_none(string $str) : void
    {
        $qiq = "{{ {$str} }}";
        $php = "<?php {$str} ?>";
        $this->assertPhp($php, $qiq);

        $qiq = "{{" . $str . "}}";
        $php = "<?php {$str} ?>";
        $this->assertPhp($php, $qiq);

        $qiq = "{{" . PHP_EOL . "    {$str}" . PHP_EOL . "}}";
        $php = "<?php" . PHP_EOL . "    {$str}" . PHP_EOL . "?>";
        $this->assertPhp($php, $qiq);
    }

    /**
     * @dataProvider echoProvider
     */
    public function testEcho_raw(string $str) : void
    {
        $qiq = "{{= {$str} }}";
        $php = "<?= {$str} ?>";
        $this->assertPhp($php, $qiq);

        $qiq = "{{ = {$str} }}";
        $php = "<?= {$str} ?>";
        $this->assertPhp($php, $qiq);

        $qiq = "{{= {$str} }}" . PHP_EOL;
        $php = "<?= {$str} ?><?= PHP_EOL ?>" . PHP_EOL;
        $this->assertPhp($php, $qiq);

        $qiq = "{{=" . PHP_EOL . "    {$str}" . PHP_EOL . "}}";
        $php = "<?=" . PHP_EOL . "    {$str}" . PHP_EOL . "?>";
        $this->assertPhp($php, $qiq);

        $qiq = "    {{=" . PHP_EOL . "        {$str}" . PHP_EOL . "    }}";
        $php = "    <?=" . PHP_EOL . "        {$str}" . PHP_EOL . "    ?>";
        $this->assertPhp($php, $qiq);
    }

    /**
     * @dataProvider echoProvider
     */
    public function testEcho_escaped(string $str) : void
    {
        foreach (['a', 'c', 'h', 'j', 'u'] as $esc) {
            $qiq = "{{{$esc} $str }}";
            $php = "<?= \$this->$esc($str) ?>";
            $this->assertPhp($php, $qiq);

            $qiq = "{{ {$esc} $str }}";
            $php = "<?= \$this->$esc($str) ?>";
            $this->assertPhp($php, $qiq);

            $qiq = "{{{$esc} $str}}";
            $php = "<?= \$this->$esc($str) ?>";
            $this->assertPhp($php, $qiq);

            $qiq = "{{ {$esc} $str}}";
            $php = "<?= \$this->$esc($str) ?>";
            $this->assertPhp($php, $qiq);

            $qiq = "{{{$esc}" . PHP_EOL . "    $str" . PHP_EOL . "}}";
            $php = "<?= \$this->$esc(" . PHP_EOL . "    $str" . PHP_EOL . ") ?>";
            $this->assertPhp($php, $qiq);

            $qiq = "    {{{$esc}" . PHP_EOL . "        $str" . PHP_EOL . "    }}";
            $php = "    <?= \$this->$esc(" . PHP_EOL . "        $str" . PHP_EOL . "    ) ?>";
            $this->assertPhp($php, $qiq);
        }
    }
    public function echoProvider() : array
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
        ];
    }

    /**
     * @dataProvider knownProvider
     */
    public function testKnown(string $code) : void
    {
        $qiq = "{{ $code }}";
        $php = "<?php $code ?>";
        $this->assertPhp($php, $qiq);

        $qiq = "{{~ $code }}";
        $php = "<?= PHP_EOL ?><?php $code ?>";
        $this->assertPhp($php, $qiq);

        $qiq = "    {{" . PHP_EOL . "        $code" . PHP_EOL . "    }}";
        $php = "    <?php" . PHP_EOL . "        $code" . PHP_EOL . "    ?>";
        $this->assertPhp($php, $qiq);
    }

    public function knownProvider() : array
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
        $qiq = '{{= textField(["name" => "street", "value" => $street]) }}';
        $php = '<?php \\Qiq\\Indent::set(\'\') ?><?= $this->textField(["name" => "street", "value" => $street]) ?>';
        $this->assertPhp($php, $qiq);

        $qiq = '{{= textField([' . PHP_EOL . '    "name" => "street", "value" => $street' . PHP_EOL . ']) }}';
        $php = '<?php \\Qiq\\Indent::set(\'\') ?><?= $this->textField([' . PHP_EOL . '    "name" => "street", "value" => $street' . PHP_EOL . ']) ?>';
        $this->assertPhp($php, $qiq);

        $qiq = '{{= helper()}}';
        $php = '<?php \\Qiq\\Indent::set(\'\') ?><?= $this->helper() ?>';
        $this->assertPhp($php, $qiq);
    }
}
