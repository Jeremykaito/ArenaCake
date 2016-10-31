<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;

class PlayersTable extends Table {

    /* Fonctions pour la validation des données*/
    
    public function validationDefault(Validator $validator) {
        return $validator
                        ->notEmpty('email', "Un nom d'utilisateur est nécessaire")
                        ->notEmpty('password', 'Un mot de passe est nécessaire')
                        ->add('password', ['length' => ['rule' => ['minLength', 6], 'message' => 'Le mot de passe doit être composé de 6 caractères minimum.',]]);
    }

    public function beforeSave($event, $entity) {
        if ($entity->isNew()) {
            $entity->id = $this->generateId();
        }
    }

    public function buildRules(RulesChecker $rules) {
        $rules->add($rules->isUnique(['email']), ['message' => 'Cet e-mail est déjà utilisé.']);
        return $rules;
    }

    /* Fonctions pour trouver un ou plusieurs joueurs */

    public function getPlayers() {
        return $this->find('all')->toArray();
    }

    public function findPlayerByEmail($email) {
        $player = $this
                ->find()
                ->where(['email' => $email])
                ->first();

        return $player;
    }

    /* Fonctions pour générer des données */

    public function generateId() {
        $s = strtoupper(md5(uniqid(rand(), true)));
        $uniqueId = substr($s, 0, 8) . '-' .
                substr($s, 8, 4) . '-' .
                substr($s, 12, 4) . '-' .
                substr($s, 16, 4) . '-' .
                substr($s, 20);
        return strtolower($uniqueId);
    }

    function generatePassword() {
        $alphabet = "azertyuiopqsdfghjklmwxcvbn7418529630AZERTYUIOPQSDFGHJKLMWXCVBN";
        $pwd = array();
        $alpha_length = strlen($alphabet) - 1;
        for ($i = 0; $i < 10; $i++) {
            $n = rand(0, $alpha_length);
            $pwd[] = $alphabet[$n];
        }
        return (implode($pwd));
    }

}
