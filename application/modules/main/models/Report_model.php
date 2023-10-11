<?php
class Report_model extends CI_Model
{

    var $table = "crf_maindata";
    var $select_column = array("crf_formno", "crf_company");
    var $order_column = array("crf_formno", NULL);


    var $tableEX = "crfex_maindata";
    var $select_columnEX = array("crfex_formno", "crfex_company");
    var $order_columnEX = array("crfex_formno", NULL);

    function make_query()
    {

        $this->db->select("crf_formno , crf_id , crf_datecreate , crf_alltype_subname , crf_status , crfcus_name , crfcus_address , crfcus_salesreps , crfsubold_name , crf_topic , crf_topic1 , crf_topic2 , crf_topic3 , crf_topic4 , crfw_salesreps , crf_sub_oldcus_changearea , crf_sub_oldcus_changeaddress , crf_sub_oldcus_changecredit , crf_sub_oldcus_changefinance , crfw_cusaddress");
        $this->db->from($this->table);
        $this->db->join('crf_alltype', 'crf_alltype.crf_alltype_subcode = crf_maindata.crf_type');
        $this->db->join('crf_customers_temp', 'crf_customers_temp.crfcus_formno = crf_maindata.crf_formno');
        $this->db->join('crf_suboldcus', 'crf_suboldcus.crfsubold_id = crf_maindata.crf_sub_oldcus_changearea');


        if (isset($_POST["search"]["value"])) {
            $this->db->like("crf_formno", $_POST["search"]["value"]);
            $this->db->or_like("crfcus_name", $_POST["search"]["value"]);
        }


        if (isset($_POST["order"])) {
            $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('crf_formno', 'DESC');
        }

    }

    function make_datatables()
    {
        $this->make_query();
        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    function get_filtered_data()
    {
        $this->make_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    function get_all_data()
    {
        $this->db->select("*");
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }




    // For Search FormNo
    function make_query_formSearch()
    {

        $this->db->select("crf_formno , crf_id , crf_datecreate , crf_alltype_subname , crf_status , crfcus_name , crfcus_address , crfcus_salesreps , crfsubold_name , crf_topic , crf_topic1 , crf_topic2 , crf_topic3 , crf_topic4 , crfw_salesreps , crf_sub_oldcus_changearea , crf_sub_oldcus_changeaddress , crf_sub_oldcus_changecredit , crf_sub_oldcus_changefinance , crfw_cusaddress");
        $this->db->from($this->table);
        $this->db->join('crf_alltype', 'crf_alltype.crf_alltype_subcode = crf_maindata.crf_type');
        $this->db->join('crf_customers_temp', 'crf_customers_temp.crfcus_formno = crf_maindata.crf_formno');
        $this->db->join('crf_suboldcus', 'crf_suboldcus.crfsubold_id = crf_maindata.crf_sub_oldcus_changearea');


        if (isset($_POST["formNo"])) {
            $this->db->like("crf_formno", $_POST["formNo"]);
        }


        if (isset($_POST["order"])) {
            $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('crf_formno', 'DESC');
        }

    }



    function make_datatables_formSearch()
    {
        $this->make_query_formSearch();
        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }


    function get_all_data_formSearch()
    {
        $this->db->select("*");
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    function get_filtered_data_formSearch()
    {
        $this->make_query();
        $query = $this->db->get();
        return $query->num_rows();
    }







    // For Export Zone // For Export Zone // For Export Zone // For Export Zone
    // For Export Zone // For Export Zone // For Export Zone // For Export Zone

    function make_queryEX()
    {
        $this->db->select("crfex_formno , crfex_id , crfex_status , crfex_customerid , crfex_maindata.crfex_datecreate , crf_alltype_subnameEN , crfex_topic , crfexcus_address , crfexcus_salesreps , crfexcus_nameEN ,crfex_curcustopic1 , crfex_curcustopic2");
        $this->db->from($this->tableEX);
        $this->db->join('crf_alltype', 'crf_alltype.crf_alltype_subcode = crfex_maindata.crfex_custype');
        $this->db->join('crfex_customers_temp', 'crfex_customers_temp.crfexcus_formno = crfex_maindata.crfex_formno');

        if (isset($_POST["search"]["value"])) {
            $this->db->like("crfex_formno", $_POST["search"]["value"]);
            $this->db->or_like("crfexcus_nameEN", $_POST["search"]["value"]);
        }

        if (isset($_POST["order"])) {
            $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('crfex_formno', 'DESC');
        }

    }

    function make_datatablesEX()
    {
        $this->make_queryEX();
        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    function get_filtered_dataEX()
    {
        $this->make_queryEX();
        $query = $this->db->get();
        return $query->num_rows();
    }

    function get_all_dataEX()
    {
        $this->db->select("*");
        $this->db->from($this->tableEX);
        return $this->db->count_all_results();
    }


    // For Export Zone // For Export Zone // For Export Zone // For Export Zone
    // For Export Zone // For Export Zone // For Export Zone // For Export Zone



}//End Report model class
