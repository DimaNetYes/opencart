<?php
Class ModelNewBannerNewBanner extends Model
{
    public function getAll()
    {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "newBanner ORDER BY banner_id");
        foreach ($query->rows as $result) {
            $banners[] = $result;
        }
        return $banners;
    }

    public function addBanner($data) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "newBanner SET name = '" . $this->db->escape($data['name']) . "', status = '" . (int)$data['status'] . "'");

        $banner_id = $this->db->getLastId();

    }
    public function editBanner($banner_id, $data)
    {
        $this->db->query("UPDATE " . DB_PREFIX . "newBanner SET name = '" . $this->db->escape($data['name']) . "', status = '" . (int)$data['status'] . "' WHERE banner_id = '" . (int)$banner_id . "'");
    }

    public function deleteBanner($banner_id)
    {
        $this->db->query("DELETE FROM " . DB_PREFIX . "newBanner WHERE banner_id = '" . (int)$banner_id . "'");
    }

}
