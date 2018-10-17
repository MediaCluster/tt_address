<?php
/**
 * @author Michael Pieperhoff (michael.pieperhoff@gmail.com)
 * @created 16.10.18 11:52
 */

namespace TYPO3\TtAddress\ViewHelpers;

use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;

class FirstImageLinkViewHelper extends AbstractTagBasedViewHelper {

    protected $tagName = 'a';

    /**
     * Set up the view helper
     */
    public function initializeArguments() {
        parent::initializeArguments();
        $this->registerUniversalTagAttributes();
        $this->registerArgument('images', 'TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', true);
        $this->registerTagAttribute('rel', 'string', 'Relationship identifier');
        $this->registerTagAttribute('target', 'string', 'The link output target');
    }

    /**
     * Render the link
     *
     * @return string
     */
    public function render() {

        /** @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage $images */
        $images = $this->arguments['images'];
        $images->rewind();

        /** @var \TYPO3\CMS\Extbase\Domain\Model\FileReference $firstImage */
        $firstImage = $images->current();
        $imageFile = $firstImage->getOriginalResource();

        $this->tag->addAttribute(
            'href',
            $imageFile->getPublicUrl()
        );

        $this->tag->setContent($this->renderChildren());

        return $this->tag->render();
    }
}