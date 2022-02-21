<?php
 
namespace Agsoftware\About\Setup\Patch\Data;

class AboutBlock implements \Magento\Framework\Setup\Patch\DataPatchInterface
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
            'title' => 'about_hero',
            'identifier' => 'about_hero',
            'is_active' => 1,
            'content' => file_get_contents(__DIR__.'/html/blocks/hero.html'),
        ];
        

        // Team - Block
        $block_data_work = [
            'title' => 'About_team',
            'identifier' => 'about_team',
            'is_active' => 1,
            'content' => file_get_contents(__DIR__.'/html/blocks/team.html'),
        ];
        // equipo - Block
        $block_data_work = [
            'title' => 'equipo',
            'identifier' => 'equipo',
            'is_active' => 1,
            'content' => file_get_contents(__DIR__.'/html/blocks/equipo.html'),
        ];

        // Gallery - Block
        $block_data_gallery = [
            'title' => 'About_gallery',
            'identifier' => 'about_gallery',
            'is_active' => 1,
            'content' => file_get_contents(__DIR__.'/html/blocks/gallery.html'),
        ];
        
        
        // Vision - Block
        $block_data_vision = [
            'title' => 'About_vision',
            'identifier' => 'about_vision',
            'is_active' => 1,
            'content' => file_get_contents(__DIR__.'/html/blocks/vision.html'),
        ];
        $this->makeBackup($block_data_vision);
        $block_vision = $this->block->create();
        $block_vision->addData($block_data_vision);
        $block_vision->setStores([0]);
        $this->blockRepository->save($block_vision);

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
