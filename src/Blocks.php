<?php
declare(strict_types=1);

namespace Qiq;

class Blocks
{
    protected const CONCAT_BUFFER = 'CONCAT_BUFFER';

    protected const CONCAT_PARENT = 'CONCAT_PARENT';

    /**
     * The number of times setBlock() has been called for each block name.
     * This keeps the different series of block parts separated.
     *
     * @var array<string, int>
     */
    protected array $count = [];

    /**
     * The stack of block names; the last one is the current block being
     * buffered.
     *
     * @var string[]
     */
    protected array $names = [];

    /**
     * The series of buffered block parts to be concatenated by getBlock().
     *
     * @var array<string, array>
     */
    protected array $parts = [];

    public function set(string $name) : void
    {
        $this->count[$name] = ($this->count[$name] ?? 0) + 1;
        $this->names[] = $name;
        ob_start();
    }

    public function end() : void
    {
        $name = array_pop($this->names);
        $count = $this->count[$name];
        $buffer = (string) ob_get_clean();
        $this->parts[$name][$count][] = [self::CONCAT_BUFFER, $buffer];
    }

    public function parent() : void
    {
        $name = (string) end($this->names);
        $count = $this->count[$name];
        $buffer = (string) ob_get_clean();
        $this->parts[$name][$count][] = [self::CONCAT_BUFFER, $buffer];
        $this->parts[$name][$count][] = [self::CONCAT_PARENT, ''];
        ob_start();
    }

    public function get() : string
    {
        $name = (string) end($this->names);
        $this->end();

        // although templates are executed childmost-up, blocks
        // are processed parentmost-down. this allows overrides
        // and parentBlock() calls to work as expected.
        $parts = array_reverse($this->parts[$name]);
        $level = [];

        foreach ($parts as $i => $concatBuffers) {
            $level[$i] = '';
            foreach ($concatBuffers as $concatBuffer) {
                list($concat, $buffer) = $concatBuffer;
                if ($concat === self::CONCAT_PARENT) {
                    $level[$i] .= $level[$i - 1] ?? '';
                } else {
                    $level[$i] .= $buffer;
                }
            }
        }

        return (string) end($level);
    }

    public function reset() : void
    {
        $this->count = [];
        $this->names = [];
        $this->parts = [];
    }
}
