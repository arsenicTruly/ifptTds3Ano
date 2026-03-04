<?php

class Link{
    private string $linkImg;
    private string $info;

    public function __construct(string $l = "link", string $i = ""){
        $this->linkImg = $l;
        $this->info = $i;
    }

    //Getters e setters
    

        /**
         * Get the value of linkImg
         */
        public function getLinkImg(): string
        {
            return $this->linkImg;
        }

        /**
         * Set the value of linkImg
         */
        public function setLinkImg(string $linkImg): self
        {
            $this->linkImg = $linkImg;

            return $this;
        }

        /**
         * Get the value of info
         */
        public function getInfo(): string
        {
            return $this->info;
        }

        /**
         * Set the value of info
         */
        public function setInfo(string $info): self
        {
            $this->info = $info;

            return $this;
        }
}