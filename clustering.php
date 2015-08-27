<?php

class Clustering {
	var $objects;
	var $nAttr;
	var $nClusters;
	var $clusterPoints;
	// array size equal to objects. contains the clusterIndex.
	var $clusterSet;
	// array of clusters consists of objectIndex
	var $clusters;
	
	function Clustering ($objects, $nClusters=2, $initialClusters=array()) {
		if (sizeof($objects)<$nClusters)
			return null;
		$this->objects = $objects;
		$this->nClusters = $nClusters;
		$this->nAttr = sizeof($objects[0]);
		if (empty($initialClusters))
			$initialClusters = array_rand($objects,$nClusters);
		foreach ($initialClusters as $value) {
			$this->clusterPoints[] = $this->objects[$value];
		}
		$this->kmeans();
	}
	// general distance 
	private static function distance($object1, $object2, $method="general") {
		if ($method=="manhatton")
			$n = 1;
		else if ($method=="euclidean")
			$n = 2;
		else	
			$n = sizeof($object1);
		for ($i=0; $i<sizeof($object1); $i++) {
			$distance += pow( abs($object1[$i] - $object2[$i]), $n );
			$distance = pow( $distance, ( 1 / $n ) );
		}
		return $distance;
	}
	// cluster the objects with cluster points
	private function cluster() {
		// find distance
		unset($this->clusters);
		for ($i=0; $i<sizeof($this->objects); $i++) {
			$min = $this->distance($this->clusterPoints[0],$this->objects[$i]);
			$minCluster = 0;
			for ($j=1; $j<$this->nClusters; $j++) {
				$distance = $this->distance($this->clusterPoints[$j],$this->objects[$i]);
				if ($distance < $min) {
					$min = $distance;
					$minCluster = $j;
				}
			}
			// cluster the objects
			$this->clusterSet[$i] = $minCluster;
			$this->clusters[$minCluster][] = $i;
		}
	}
	private function kmeans() {
		// find new cluster points
		$n=0;
		while ($n<5) {
			$n++;
			// to stop the process
			$isOver = true;			
			$this->cluster();
			unset($newClusterPoints);
			for ($i=0; $i<$this->nClusters; $i++) {
				// foreach attribute of an object
				$nObjects = sizeof($this->clusters[$i]);
				for ($k=0; $k<$this->nAttr; $k++) {
					// foreach object in a cluster
					for ($j=0; $j<$nObjects; $j++) {			
						$newClusterPoints[$i][$k] += $this->objects[$this->clusters[$i][$j]][$k] / $nObjects;						
					}
					if ($isOver) {	// if all attr are same and ...  
						$isOver = (round($this->clusterPoints[$i][$k]) == round($newClusterPoints[$i][$k]))?true:false;
					}
				}
				if (!$isOver)
					$this->clusterPoints[$i] = $newClusterPoints[$i];
			}
			if ($isOver)
				return;
		}
	}
}
/*
$points = array(array(1,1),array(5,6),array(5,5),array(1,0));
$cluster = new Clustering($points,2);
print_r($cluster->clusters);*/
?>