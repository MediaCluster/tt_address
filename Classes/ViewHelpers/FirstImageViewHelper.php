<?php
/**
 * @author Michael Pieperhoff (michael.pieperhoff@gmail.com)
 * @created 16.10.18 11:14
 */

namespace TYPO3\TtAddress\ViewHelpers;

use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;

class FirstImageViewHelper extends AbstractTagBasedViewHelper {

    protected $tagName = 'img';

    /**
     * Set up the view helper
     */
    public function initializeArguments() {
        parent::initializeArguments();
        $this->registerUniversalTagAttributes();
        $this->registerArgument('images', 'TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', true);
        $this->registerArgument('addItemProp', 'bool', 'Whether to inlcude the itemprop for this image', false, false);
        $this->registerTagAttribute('alt', 'string', 'An alternate title for the image');
        $this->registerTagAttribute('height', 'string', 'The image height');
        $this->registerTagAttribute('width', 'string', 'The image height');
    }

    /**
     * Render the image tag with the correct image url
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
            'src',
            $imageFile->getPublicUrl()
        );

        if(true === $this->arguments['addItemProp']) {
            $this->tag->addAttribute(
                'itemprop',
                $firstImage
            );
        }

        return $this->tag->render();
    }
}