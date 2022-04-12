<?php

namespace Agsoftware\HirePqr\Setup\Patch\Data;

class Contactv2 implements \Magento\Framework\Setup\Patch\DataPatchInterface
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
        $this->moduleDataSetup->getConnection()->startSetup();
        //code
        $data = [
          
            'title' => 'Contact',
            'identifier' => 'contactv1',
            
            'is_active' => 1,
           
            'content' => file_get_contents(__DIR__.'/html/Contacto.html'),

        ];
        
        $this->makeBackup($data);
        $page = $this->page->create();
        $page->addData($data);
        $page->setStores([0]);
        $this->pageRepository->save($page);

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    public function makeBackup($data){
        $page = $this->page->create()->load($data['identifier'],'identifier');
        if($page->getId()>0){
            $backup = $this->page->create()->load($data['identifier'].'-backup','identifier');
            if($backup->getId()>0){
                $backup->delete();
            }
            $page->setIdentifier($data['identifier'].'-backup')->setActive(0)->save();
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
