<?php
    interface FilmDTO {
        public function setId($id);
		public function getId();
        public function setTittle($tittle);
		public function getTittle();
        public function setDuration($duration);
		public function getDuration();
        public function setLanguage($language);
		public function getLanguage();
    }
?>