<?php
 
namespace Agsoftware\Service\Setup\Patch\Data;

class ServiceBlock implements \Magento\Framework\Setup\Patch\DataPatchInterface
{
    /**
     * CreateHeaderBlock constructor.
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param \Magento\Cms\Model\BlockRepository $blockRepository
     * @param \Magento\Cms\Api\Data\BlockInterface $block
     */
    public function __construct(
        \Magento\Framework\Setup\ModuleDataSetupInterface $moduleDataSetup,
        \Magento\Cms\Model\BlockRepository $blockRepository,
        \Magento\Cms\Api\Data\BlockInterfaceFactory $block,
        \Magento\Cms\Api\GetBlockByIdentifierInterface $blockByIdentifier
    ) {
        $this->blockRepository = $blockRepository;
        $this->block = $block;
        $this->moduleDataSetup = $moduleDataSetup;
        $this->blockByIdentifier = $blockByIdentifier;
    }
    /**
     * {@inheritdoc}
     */
    public function apply()
    { 
        //$this->moduleDataSetup->startSetup();
        
        $this->moduleDataSetup->getConnection()->startSetup();
        
        // Hero - Block
        $block_data_hero = [
            'title' => 'service_hero',
            'identifier' => 'service_hero',
            'is_active' => 1,
            'content' => file_get_contents(__DIR__.'/html/blocks/hero.html'),
        ];
        $this->makeBackup($block_data_hero);
        $block_hero = $this->block->create();
        $block_hero->addData($block_data_hero);
        $block_hero->setStores([0]);
        $this->blockRepository->save($block_hero);

        // Work - Block
        $block_data_work = [
            'title' => 'service_work',
            'identifier' => 'service_work',
            'is_active' => 1,
            'content' => file_get_contents(__DIR__.'/html/blocks/work.html'),
        ];
        $this->makeBackup($block_data_work);
        $block_work = $this->block->create();
        $block_work->addData($block_data_work);
        $block_work->setStores([0]);
        $this->blockRepository->save($block_work);

        // Services - Block
        $block_data_services = [
            'title' => 'service_services',
            'identifier' => 'service_services',
            'is_active' => 1,
            'content' => file_get_contents(__DIR__.'/html/blocks/services.html'),
        ];
        $this->makeBackup($block_data_services);
        $block_services = $this->block->create();
        $block_services->addData($block_data_services);
        $block_services->setStores([0]);
        $this->blockRepository->save($block_services);

        
        // Card - Block
        $block_data_card = [
            'title' => 'service_card',
            'identifier' => 'service_card',
            'is_active' => 1,
            'content' => file_get_contents(__DIR__.'/html/blocks/card.html'),
        ];
        $this->makeBackup($block_data_card);
        $block_card = $this->block->create();
        $block_card->addData($block_data_card);
        $block_card->setStores([0]);
        $this->blockRepository->save($block_card);


        // Author - Block
        $block_data_author = [
            'title' => 'service_author',
            'identifier' => 'service_author',
            'is_active' => 1,
            'content' => file_get_contents(__DIR__.'/html/blocks/author.html'),
        ];
        $this->makeBackup($block_data_author);
        $block_author = $this->block->create();
        $block_author->addData($block_data_author);
        $block_author->setStores([0]);
        $this->blockRepository->save($block_author);


        // Features - Block
        $block_data_features = [
            'title' => 'service_features',
            'identifier' => 'service_features',
            'is_active' => 1,
            'content' => file_get_contents(__DIR__.'/html/blocks/features.html'),
        ];
        $this->makeBackup($block_data_features);
        $block_features = $this->block->create();
        $block_features->addData($block_data_features);
        $block_features->setStores([0]);
        $this->blockRepository->save($block_features);


        // More - Block
        $block_data_more = [
            'title' => 'service_more',
            'identifier' => 'service_more',
            'is_active' => 1,
            'content' => file_get_contents(__DIR__.'/html/blocks/more.html'),
        ];
        $this->makeBackup($block_data_more);
        $block_more = $this->block->create();
        $block_more->addData($block_data_more);
        $block_more->setStores([0]);
        $this->blockRepository->save($block_more);

        
        // ContactForm - Block
        $block_data_contactForm = [
            'title' => 'service_contactForm',
            'identifier' => 'service_contactForm',
            'is_active' => 1,
            'content' => file_get_contents(__DIR__.'/html/blocks/contactForm.html'),
        ];
        $this->makeBackup($block_data_contactForm);
        $block_contactForm = $this->block->create();
        $block_contactForm->addData($block_data_contactForm);
        $block_contactForm->setStores([0]);
        $this->blockRepository->save($block_contactForm);


        // Contact - Block
        $block_data_contact = [
            'title' => 'service_contact',
            'identifier' => 'service_contact',
            'is_active' => 1,
            'content' => file_get_contents(__DIR__.'/html/blocks/contact.html'),
        ];
        $this->makeBackup($block_data_contact);
        $block_contact = $this->block->create();
        $block_contact->addData($block_data_contact);
        $block_contact->setStores([0]);
        $this->blockRepository->save($block_contact);


        $this->moduleDataSetup->endSetup();

    }

    public function makeBackup($data)
    {
        $block = $this->block->create()->load($data['identifier'],'identifier');
        if($block->getId()>0)
        {
            $backup = $this->block->create()->load($data['identifier'].'-backup','identifier');

            if($backup->getId() > 0)
            {
                $backup->delete();
            }

            $block->setIdentifier($data['identifier'].'-backup')->setActive(0)->save();
        }
    }

      /**
     * @inheritdoc
     */
    public static function getDependencies()
    {
        return [];
    }
    /**
     * @inheritdoc
     */
    public function getAliases()
    {
        return [];
    }
    /**
     * Revert patch
     */
    public function revert()
    {
        $this->moduleDataSetup->getConnection()->startSetup();
        //code
        $this->moduleDataSetup->getConnection()->endSetup();
    }
}
