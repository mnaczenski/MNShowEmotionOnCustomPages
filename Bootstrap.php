<?php


/**
 * MNShowEmotionOnCustomPages
 * @author Moritz Naczenski
 */

use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\InstallContext;

 class Shopware_Plugins_Frontend_MNShowEmotionOnCustomPages_Bootstrap extends Shopware_Components_Plugin_Bootstrap

{
	public function getversion()
	{
		return '1.0.0';
	}

	public function getlabel()
	{
		return 'Show Emotion On Custom Pages';
	}

	public function install(InstallContext $context)
	{
		$this -> subscribeEvent(
			'Enlight_Controller_Action_PostDispatchSecure_Frontend',
			'onFrontendPostDispatch'
			);

		$this -> subscribeEvent(
			'Enlight_Controller_Action_PostDispatchSecure_Frontend_Custom',
			'onFrontendPostDispatchCustom'
		);

		$this -> createConfig();

        	//register service
        	$service = $this->get('shopware_attribute.crud_service');
		//create blog attribute
        	$service->update('s_blog_attributes', 'emotionidforblog', 'single_selection', [
            		'label' => 'Einkaufswelt für Blogbeitrag',
            		'displayInBackend' => true,
            		'entity' => 'Shopware\Models\Emotion\Emotion'
       		 ]);
		//create attribute for shop-pages
		$service->update('s_cms_static_attributes', 'emotionidforshoppages', 'single_selection', [
			'label' => 'Einkaufswelt für Shopseiten',
			'displayInBackend' => true,
			'entity' => 'Shopware\Models\Emotion\Emotion'
		]);
		
		return true;
	}

	public function onFrontendPostDispatch(Enlight_Event_EventArgs $args)
	{
	    
		/** @var \Enlight_Controller_Action $controller */
		$controller = $args->get('subject');

		/** Add Template directory */
		$view = $controller->View();
		$view->addTemplateDir(
		__DIR__ . '/Views'
		);

		/** display shoppingworlds on blog pages*/
		$view->assign('showblogemotion', $this->Config()->get('showblogemotion'));
		$view->assign('emotionidforblog', $this->Config()->get('emotionidforblog'));


	}

	 public function onFrontendPostDispatchCustom(Enlight_Event_EventArgs $args)
	 {

		 /** @var \Enlight_Controller_Action $controller */
		 $controller = $args->get('subject');

		 /** Add Template directory */
		 $view = $controller->View();
		 $view->addTemplateDir(
			 __DIR__ . '/Views'
		 );

		 /** display shoppingworlds on shoppages */
		 $view->assign('showshoppageemotion', $this->Config()->get('showshoppageemotion'));

		 /** @var Shopware\Bundle\AttributeBundle\Service\DataLoader $service */
		 /** get blog id and assign attributes to view */
		 $service = $this->get('shopware_attribute.data_loader');

		 $customid = $view->getAssign('sCustomPage')['id'];
		 $data = $service->load('s_cms_static_attributes', $customid);
		 $view->assign('cms_atttributes', $data);
	 }



	private function createConfig()
	{
		/** "emotion for blog" configuration **/
		$this->Form()->setElement('select', 'showblogemotion',
			array(
				'label' => 'Einkaufswelt im Blog anzeigen?',
				'store' => array(
					array(showblogemotiony, 'Ja'),
					array(showblogemotionn, 'Nein'),
				),
				'value' => showblogemotionn,
			)
		);

		/** "emotion id for blog" configuration **/
		$this->Form()->setElement('number', 'emotionidforblog',
			array(
				'label' => 'EmotionID für den Blog',
				'minValue' => 0,
				'value' => 0,
			)
		);

		/** "emotion for shoppages" configuration **/
		$this->Form()->setElement('select', 'showshoppageemotion',
			array(
				'label' => 'Einkaufswelten auf Shopseiten anzeigen?',
				'store' => array(
					array(showshoppageemotiony, 'Ja'),
					array(showshoppageemotionn, 'Nein'),
				),
				'value' => showshoppageemotionn,
			)
		);


		$this->addFormTranslations(
			array(
				'en_GB' => array(
					'plugin_form' => array(
						'label' => 'Show Emotion On Custom Pages'
					),
					'showblogemotion' => array(
						'label' => 'Show shopping worlds in blogs?'
					),
					'emotionidforblog' => array(
						'label' => 'EmotionID for blog'
					),
					'showshoppageemotion' => array(
						'label' => 'Show shopping worlds on shop pages?'
					)
				)
			)
		);



	}
}
?>
