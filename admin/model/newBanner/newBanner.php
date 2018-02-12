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

    public function deleteRow ($id){
        $this->db->query("DELETE FROM " . DB_PREFIX . "comments WHERE id = ".$id);
        return 'deleted';
    }

}
