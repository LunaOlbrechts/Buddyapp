<?php

include_once(__DIR__ . "/Db.php");

    class Emoji {
        private $emoji;
        private $messageId;

        /**
         * Get the value of emoji
         */ 
        public function getEmoji()
        {
                return $this->emoji;
        }

        /**
         * Set the value of emoji
         *
         * @return  self
         */ 
        public function setEmoji($emoji)
        {
                $this->emoji = $emoji;

                return $this;
        }

        /**
         * Get the value of messageId
         */ 
        public function getMessageId()
        {
                return $this->messageId;
        }

        /**
         * Set the value of messageId
         *
         * @return  self
         */ 
        public function setMessageId($messageId)
        {
                $this->messageId = $messageId;

                return $this;
        }

        public function save(){
            $conn = Db::getConnection();
            $statement = $conn->prepare("UPDATE tl_chat set emoji = :emoji WHERE id = :id");

            $emoji = $this->getEmoji();
            $id = $this->getMessageId();

            $statement->bindValue(":emoji", $emoji);
            $statement->bindValue(":id", $id);

            $result = $statement->execute();
            return $result;
        }
    }