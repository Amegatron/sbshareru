<?php namespace SbShare\Decoda;

class Decoda extends \Decoda\Decoda {

    /**
     * Convert the chunks into a child parent hierarchy of nodes.
     *
     * @param array $chunks
     * @param array $wrapper
     * @param int $depth
     * @return array
     */
    protected function _extractNodes(array $chunks, array $wrapper = array(), $depth = 0) {
        $chunks = $this->_cleanChunks($chunks, $wrapper);
        $nodes = array();
        $tag = array();
        $openIndex = -1;
        $openCount = -1;
        $closeCount = -1;
        $count = count($chunks);
        $i = 0;

        while ($i < $count) {
            $chunk = $chunks[$i];

            // Check for an empty tag as we only need to match the open and closing tags
            // The inner chunks will be extracted once a match is found
            if ($chunk['type'] === self::TAG_NONE && empty($tag)) {
                $nodes[] = $chunk['text'];

            } else if ($chunk['type'] === self::TAG_SELF_CLOSE && empty($tag)) {
                $chunk['children'] = array();
                $nodes[] = $chunk;

            } else if ($chunk['type'] === self::TAG_OPEN) {
                $openCount++;

                if (empty($tag)) {
                    $openIndex = $i;
                    $tag = $chunk;
                }

            } else if ($chunk['type'] === self::TAG_CLOSE) {
                $closeCount++;

                if ($openCount === $closeCount && $chunk['tag'] === $tag['tag']) {
                    $index = $i - $openIndex;
                    $tag = array();

                    // Only reduce if not last index
                    if ($index !== $count) {
                        $index = $index - 1;
                    }

                    // Slice a section of the array if the correct closing tag is found
                    $node = $chunks[$openIndex];
                    $node['depth'] = $depth;
                    $node['children'] = $this->_extractNodes(array_slice($chunks, ($openIndex + 1), $index), $chunks[$openIndex], $depth + 1);
                    $nodes[] = $node;

                    // There is no opening or a broken opening tag, which means
                    // $closeCount should not have been incremented before >> revert
                } else if (empty($tag)) {
                    $closeCount--;
                }
            }

            $i++;
        }

        return $nodes;
    }
} 
