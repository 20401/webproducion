<?php
 
namespace Agsoftware\About\Setup\Patch\Data;

class AboutPage implements \Magento\Framework\Setup\Patch\DataPatchInterface
{
    /**
     * CreateHeaderpage constructor.
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param \Magento\Cms\Model\pageRepository $pageRepository
     * @param \Magento\Cms\Api\Data\pageInterface $page
     */
    public function __construct(
        \Magento\Framework\Setup\ModuleDataSetupInterface $moduleDataSetup,
        \Magento\Cms\Model\PageRepository $pageRepository,
        \Magento\Cms\Api\Data\PageInterfaceFactory $page,
        \Magento\Cms\Api\GetPageByIdentifierInterface $pageByIdentifier
    ) {
        $this->pageRepository = $pageRepository;
        $this->page = $page;
        $this->moduleDataSetup = $moduleDataSetup;
        $this->pageByIdentifier = $pageByIdentifier;
    }
    
    /**
     * {@inheritdoc}
     */
    public function apply()
    { 
        //$this->moduleDataSetup->startSetup();
        $this->moduleDataSetup->getConnection()->startSetup();
        //code
        
       //codigo para eliminar paginas
        //$this->page->create()->load('fundacion','identifier')->delete();

        $page_data = [
            'title' => 'about',
            'identifier' => 'about',
            'is_active' => 1,
            'page_layout' => 'Page -- Full Width',
            'meta_keywords' =>'about',
            'creation_time'=>date('y-M-d'),
            'update_time'=>date('y-M-d'),
            'sort_order'=>0,
            'content' => file_get_contents(__DIR__.'/html/pages/about.html'),
        ];
        
        $page = $this->page->create()->load('principal_curriculum','identifier');
        $page->addData($page_data);
        $page->setStores([0]);

        $this->pageRepository->save($page);
        $this->moduleDataSetup->getConnection()->endSetup();
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