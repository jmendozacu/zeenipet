<?php

/*
 * Author Rudyuk Vitalij Anatolievich
 * Email rvansp@gmail.com
 * Blog www.cervic.info
 */

class Infomodus_Upslabel_Adminhtml_PdflabelsController extends Mage_Core_Controller_Front_Action
{

    public function indexAction()
    {
        $order_ids = $this->getRequest()->getParam('order_ids');
        $img_path = Mage::getBaseDir('media') . '/upslabel/label/';
        $url_image_path = Mage::getBaseUrl('media') . 'upslabel/label/';
        $pdf = new Zend_Pdf();
        $i = 0;
        //$pdf->pages = array_reverse($pdf->pages);
        if (!is_array($order_ids)) {
            $order_ids = explode(',', $order_ids);
        }
        $width = strlen(Mage::getStoreConfig('upslabel/profile/dimensionx'))>0 ? Mage::getStoreConfig('upslabel/profile/dimensionx'):1400 / 2.6;
        $heigh = strlen(Mage::getStoreConfig('upslabel/profile/dimensiony'))>0 ? Mage::getStoreConfig('upslabel/profile/dimensiony'):800 / 2.6;
        if(strlen(Mage::getStoreConfig('upslabel/profile/holstx'))>0 && strlen(Mage::getStoreConfig('upslabel/profile/holsty'))>0){
            $holstSize = Mage::getStoreConfig('upslabel/profile/holstx').':'.Mage::getStoreConfig('upslabel/profile/holsty').':';
        }
        else {
            $holstSize = Zend_Pdf_Page::SIZE_A4;
        }
        foreach ($order_ids as $order_id) {
            $collections = Mage::getModel('upslabel/upslabel');
            $colls = $collections->getCollection()->addFieldToFilter('order_id', $order_id)->addFieldToFilter('type', 'shipment');
            foreach ($colls AS $k => $v) {
                $coll = $v['upslabel_id'];
                $collection = Mage::getModel('upslabel/upslabel')->load($coll);
                if ($collection->getOrderId() == $order_id) {
                    if (file_exists($img_path . $collection->getLabelname())) {
                        $page = $pdf->newPage($holstSize);
                        $pdf->pages[] = $page;
                        $f_cont = file_get_contents($img_path . $collection->getLabelname());
                        $img = imagecreatefromstring($f_cont);
                        if (Mage::getStoreConfig('upslabel/profile/verticalprint') == 1) {
                            $FullImage_width = imagesx($img);
                            $FullImage_height = imagesy($img);
                            $full_id = imagecreatetruecolor($FullImage_width, $FullImage_height);
                            $col = imagecolorallocate($img, 125, 174, 240);
                            $IMGfuul = imagerotate($img, -90, $col);
                        }
                        else {
                            $IMGfuul = $img;
                        }
                        $rnd = rand(10000, 999999);
                        imagejpeg($IMGfuul, $img_path . 'lbl' . $rnd . '.jpeg', 100);
                        $image = Zend_Pdf_Image::imageWithPath($img_path . 'lbl' . $rnd . '.jpeg');
                        $page->drawImage($image, 0, 0, $width, $heigh);
                        unlink($img_path . 'lbl' . $rnd . '.jpeg');
                        $i++;
                    }
                }
                unset($IMGfuul);
            }
        }
        //$pdf->save();
        if ($i > 0) {
            $pdfData = $pdf->render();

            header("Content-Disposition: inline; filename=result.pdf");
            header("Content-type: application/x-pdf");
            echo $pdfData;
        }
    }

    public function onepdfAction()
    {
        $order_id = $this->getRequest()->getParam('order_id');
        $shipment_id = $this->getRequest()->getParam('shipment_id');
        $type = $this->getRequest()->getParam('type');
        $img_path = Mage::getBaseDir('media') . '/upslabel/label/';
        $url_image_path = Mage::getBaseUrl('media') . 'upslabel/label/';
        $pdf = new Zend_Pdf();
        $i = 0;
        $collections = Mage::getModel('upslabel/upslabel');
        $colls = $collections->getCollection()->addFieldToFilter('shipment_id', $shipment_id)->addFieldToFilter('type', $type);
        foreach ($colls AS $k => $v) {
            $coll = $v['upslabel_id'];
            break;
        }
        $width = strlen(Mage::getStoreConfig('upslabel/profile/dimensionx'))>0 ? Mage::getStoreConfig('upslabel/profile/dimensionx'):1400 / 2.6;
        $heigh = strlen(Mage::getStoreConfig('upslabel/profile/dimensiony'))>0 ? Mage::getStoreConfig('upslabel/profile/dimensiony'):800 / 2.6;
        if(strlen(Mage::getStoreConfig('upslabel/profile/holstx'))>0 && strlen(Mage::getStoreConfig('upslabel/profile/holsty'))>0){
            $holstSize = Mage::getStoreConfig('upslabel/profile/holstx').':'.Mage::getStoreConfig('upslabel/profile/holsty').':';
        }
        else {
            $holstSize = Zend_Pdf_Page::SIZE_A4;
        }
        $collection_one = Mage::getModel('upslabel/upslabel')->load($coll);
        if ($collection_one->getOrderId() == $order_id) {
            foreach($colls AS $collection){
                if (file_exists($img_path . $collection->getLabelname())) {
                    $page = $pdf->newPage($holstSize);
                    $pdf->pages[] = $page;
                    $f_cont = file_get_contents($img_path . $collection->getLabelname());
                    $img = imagecreatefromstring($f_cont);
                    if (Mage::getStoreConfig('upslabel/profile/verticalprint') == 1) {
                        $FullImage_width = imagesx($img);
                        $FullImage_height = imagesy($img);
                        $full_id = imagecreatetruecolor($FullImage_width, $FullImage_height);
                        $col = imagecolorallocate($img, 125, 174, 240);
                        $IMGfuul = imagerotate($img, -90, $col);
                    }
                    else {
                        $IMGfuul = $img;
                    }
                    $rnd = rand(10000, 999999);
                    imagejpeg($IMGfuul, $img_path . 'lbl' . $rnd . '.jpeg', 100);
                    $image = Zend_Pdf_Image::imageWithPath($img_path . 'lbl' . $rnd . '.jpeg');
                    $page->drawImage($image, 0, 0, $width, $heigh);
                    unlink($img_path . 'lbl' . $rnd . '.jpeg');
                    $i++;
                }
            }
        }
        if ($i > 0) {
            $pdfData = $pdf->render();

            header("Content-Disposition: inline; filename=result.pdf");
            header("Content-type: application/x-pdf");
            echo $pdfData;
        }
    }
}
