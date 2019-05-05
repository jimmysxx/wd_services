<?php

namespace Drupal\wd_services;

use Drupal\taxonomy\Entity\Term;

class Taxonomy{
    /**
     * Returns array of taxonomy terms from vocabulary id
     * the array keys are the taxonomy ids
     * suitable for select lists
     *
     * @param $vid
     * @return array
     */
    public function getVocabularyTerms($vid){
        $options = [];
        $terms =\Drupal::entityTypeManager()
            ->getStorage('taxonomy_term')
            ->loadTree($vid);
        foreach ($terms as $term) {
            $options[$term->tid] = $term->name;
        }
        return $options;
    }

    /**
     * Returns the term name
     * given a term id
     *
     * @param $tid
     * @return mixed|null|string
     */
    public function getTermName($tid){
        if($tid){
            $term = Term::load($tid);
            if($term){
                return $term->getName();
            }
        }
        return '';
    }

    /**
     * Creates term if it doesn't already exist
     * used for auto complete form fields
     *
     * @param $term
     * term id if it exists
     * array of term entity otherwise
     *
     * @return string
     * term id
     */
    public function termAutoCreate($term){
        if(empty($term)){
            return '';
        }
        elseif(is_string($term)){
            return $term;
        }
        elseif(isset($term['entity']) && ($term['entity'] instanceof \Drupal\taxonomy\Entity\Term)){
            $term['entity']->save();
            return $term->id();
        }
        return '';
    }
}