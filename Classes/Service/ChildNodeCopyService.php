<?php
namespace Mindscreen\Neos\NodeTemplatesDemo\Service;

use Flowpack\NodeTemplates\Service\EelEvaluationService;
use Neos\ContentRepository\Domain\Model\NodeInterface;
use Neos\Flow\Annotations as Flow;
use Neos\Neos\Service\NodeOperations;

/**
 */
class ChildNodeCopyService
{

    /**
     * @var EelEvaluationService
     * @Flow\Inject
     */
    protected $eelEvaluationService;

    /**
     * @var NodeOperations
     * @Flow\Inject
     */
    protected $nodeOperations;

    /**
     * @param NodeInterface $node
     * @param array $context
     * @param array $options
     */
    public function copyChildNodesAfterTemplateApplication(NodeInterface $node, array $context, array $options) {
        // Copy child nodes from template
        if (isset($options['childNodesToCopy']) && preg_match(\Neos\Eel\Package::EelExpressionRecognizer, $options['childNodesToCopy'])) {
            $childNodes = $this->eelEvaluationService->evaluateEelExpression($options['childNodesToCopy'], $context);
            /** @var NodeInterface $childNode */
            foreach ($childNodes as $childNode) {
                $this->nodeOperations->copy($childNode, $node, 'into');
            }
        }
    }

}
