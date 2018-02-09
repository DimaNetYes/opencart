<?php
Class ModelNewBannerNewBanner extends Model
{
    public function addBanner($data) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "banner SET name = '" . $this->db->escape($data['name']) . "', status = '" . (int)$data['status'] . "'");

        $banner_id = $this->db->getLastId();

        if (isset($data['banner_image'])) {
            foreach ($data['banner_image'] as $banner_image) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "banner_image SET banner_id = '" . (int)$banner_id . "', link = '" .  $this->db->escape($banner_image['link']) . "', image = '" .  $this->db->escape($banner_image['image']) . "'");

                $banner_image_id = $this->db->getLastId();

                foreach ($banner_image['banner_image_description'] as $language_id => $banner_image_description) {
                    $this->db->query("INSERT INTO " . DB_PREFIX . "banner_image_description SET banner_image_id = '" . (int)$banner_image_id . "', language_id = '" . (int)$language_id . "', banner_id = '" . (int)$banner_id . "', title = '" .  $this->db->escape($banner_image_description['title']) . "'");
                }
            }
        }
    }

}
