<?php

use Illuminate\Database\Seeder;
use App\Category;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categoryRecords = [
        ['id' => 1,'parent_id' => 0,'section_id' => 1,'category_name' => 'Cordless Tools','category_discount' => '0.00','category_description' => '','url' => 'cordless-tools','meta_title' => '','meta_description' => '','meta_keywords' => '','status' => '1','created_at' => NULL,'updated_at' => '2021-04-01 03:04:49'],
        ['id' => 2,'parent_id' => 0,'section_id' => 1,'category_name' => 'Corded Drills','category_discount' => '0.00','category_description' => '','url' => 'corded-drills','meta_title' => '','meta_description' => '','meta_keywords' => '','status' => '1','created_at' => NULL,'updated_at' => NULL],
        ['id' => 3,'parent_id' => 0,'section_id' => 1,'category_name' => 'Demolition Tools','category_discount' => '0.00','category_description' => '','url' => 'demolition-tools','meta_title' => '','meta_description' => '','meta_keywords' => '','status' => '1','created_at' => NULL,'updated_at' => NULL],
        ['id' => 4,'parent_id' => 0,'section_id' => 1,'category_name' => 'Hammer Tools','category_discount' => '0.00','category_description' => '','url' => 'hammer-tools','meta_title' => '','meta_description' => '','meta_keywords' => '','status' => '1','created_at' => NULL,'updated_at' => '2021-03-31 07:05:46'],
        ['id' => 5,'parent_id' => 0,'section_id' => 1,'category_name' => 'Grinders','category_discount' => '0.00','category_description' => '','url' => 'grinders','meta_title' => '','meta_description' => '','meta_keywords' => '','status' => '1','created_at' => NULL,'updated_at' => NULL],
        ['id' => 6,'parent_id' => 0,'section_id' => 1,'category_name' => 'Sanders','category_discount' => '0.00','category_description' => '','url' => 'sanders','meta_title' => '','meta_description' => '','meta_keywords' => '','status' => '1','created_at' => NULL,'updated_at' => NULL],
        ['id' => 7,'parent_id' => 0,'section_id' => 1,'category_name' => 'Planers','category_discount' => '0.00','category_description' => '','url' => 'planers','meta_title' => '','meta_description' => '','meta_keywords' => '','status' => '1','created_at' => NULL,'updated_at' => NULL],
        ['id' => 8,'parent_id' => 0,'section_id' => 1,'category_name' => 'Wood Saws','category_discount' => '0.00','category_description' => '','url' => 'wood-saws','meta_title' => '','meta_description' => '','meta_keywords' => '','status' => '1','created_at' => NULL,'updated_at' => NULL],
        ['id' => 9,'parent_id' => 0,'section_id' => 1,'category_name' => 'Others','category_discount' => '0.00','category_description' => '','url' => 'other-tools','meta_title' => '','meta_description' => '','meta_keywords' => '','status' => '1','created_at' => NULL,'updated_at' => NULL],
        ['id' => 10,'parent_id' => 0,'section_id' => 1,'category_name' => 'Bench Top Tools','category_discount' => '0.00','category_description' => '','url' => 'bench-top-tools','meta_title' => '','meta_description' => '','meta_keywords' => '','status' => '1','created_at' => NULL,'updated_at' => NULL],
        ['id' => 11,'parent_id' => 0,'section_id' => 1,'category_name' => 'Pressure Washers','category_discount' => '0.00','category_description' => '','url' => 'pressure-washers','meta_title' => '','meta_description' => '','meta_keywords' => '','status' => '1','created_at' => NULL,'updated_at' => NULL],
        ['id' => 12,'parent_id' => 0,'section_id' => 1,'category_name' => 'Wielding Machines','category_discount' => '0.00','category_description' => '','url' => 'wielding-machines','meta_title' => '','meta_description' => '','meta_keywords' => '','status' => '1','created_at' => NULL,'updated_at' => NULL],
        ['id' => 13,'parent_id' => 0,'section_id' => 1,'category_name' => 'Air Compressors','category_discount' => '0.00','category_description' => '','url' => 'air-compressors','meta_title' => '','meta_description' => '','meta_keywords' => '','status' => '1','created_at' => NULL,'updated_at' => NULL],
        ['id' => 14,'parent_id' => 0,'section_id' => 2,'category_name' => 'SP Flex','category_discount' => '0.00','category_description' => '','url' => 'sp-flex','meta_title' => '','meta_description' => '','meta_keywords' => '','status' => '1','created_at' => NULL,'updated_at' => NULL],
        ['id' => 15,'parent_id' => 0,'section_id' => 2,'category_name' => 'Hammer','category_discount' => '0.00','category_description' => '','url' => 'hammer','meta_title' => '','meta_description' => '','meta_keywords' => '','status' => '1','created_at' => NULL,'updated_at' => NULL],
        ['id' => 16,'parent_id' => 0,'section_id' => 3,'category_name' => 'Submersible & Sewage Pumps','category_discount' => '0.00','category_description' => '','url' => 'submersible-sewage-pumps','meta_title' => '','meta_description' => '','meta_keywords' => '','status' => '1','created_at' => NULL,'updated_at' => NULL],
        ['id' => 17,'parent_id' => 0,'section_id' => 3,'category_name' => 'Surface Pumps','category_discount' => '0.00','category_description' => '','url' => 'surface-pumps','meta_title' => '','meta_description' => '','meta_keywords' => '','status' => '1','created_at' => NULL,'updated_at' => NULL],
        ['id' => 18,'parent_id' => 1,'section_id' => 1,'category_name' => 'Cordless Drills','category_discount' => '0.00','category_description' => '','url' => 'cordless-drills','meta_title' => '','meta_description' => '','meta_keywords' => '','status' => '1','created_at' => '2021-03-31 06:56:47','updated_at' => '2021-03-31 06:56:47'],
        ['id' => 19,'parent_id' => 1,'section_id' => 1,'category_name' => 'Cordless  Hammer Drills','category_discount' => '0.00','category_description' => '','url' => 'cordless-hammer-drills','meta_title' => '','meta_description' => '','meta_keywords' => '','status' => '1','created_at' => '2021-03-31 06:57:57','updated_at' => '2021-03-31 06:57:57'],
        ['id' => 20,'parent_id' => 2,'section_id' => 1,'category_name' => 'Impact Driver','category_discount' => '0.00','category_description' => '','url' => 'impact-driver','meta_title' => '','meta_description' => '','meta_keywords' => '','status' => '1','created_at' => '2021-03-31 06:59:28','updated_at' => '2021-03-31 07:01:03'],
        ['id' => 21,'parent_id' => 2,'section_id' => 1,'category_name' => 'Electric Screwdriver','category_discount' => '0.00','category_description' => '','url' => 'electric-screwdriver','meta_title' => '','meta_description' => '','meta_keywords' => '','status' => '1','created_at' => '2021-03-31 07:00:47','updated_at' => '2021-03-31 07:00:47'],
        ['id' => 22,'parent_id' => 2,'section_id' => 1,'category_name' => 'Electric Drill','category_discount' => '0.00','category_description' => '','url' => 'electric-drill','meta_title' => '','meta_description' => '','meta_keywords' => '','status' => '1','created_at' => '2021-03-31 07:01:51','updated_at' => '2021-03-31 07:01:51'],
        ['id' => 23,'parent_id' => 2,'section_id' => 1,'category_name' => 'Hammer Drill','category_discount' => '0.00','category_description' => '','url' => 'hammer-drill','meta_title' => '','meta_description' => '','meta_keywords' => '','status' => '1','created_at' => '2021-03-31 07:02:54','updated_at' => '2021-03-31 07:02:54'],
        ['id' => 24,'parent_id' => 3,'section_id' => 1,'category_name' => 'Rotary Hammer','category_discount' => '0.00','category_description' => '','url' => 'rotary-hammer','meta_title' => '','meta_description' => '','meta_keywords' => '','status' => '1','created_at' => '2021-03-31 07:03:54','updated_at' => '2021-03-31 07:04:44'],
        ['id' => 25,'parent_id' => 4,'section_id' => 1,'category_name' => 'Demolition Hammer','category_discount' => '0.00','category_description' => '','url' => 'demolition-hammer','meta_title' => '','meta_description' => '','meta_keywords' => '','status' => '1','created_at' => '2021-03-31 07:05:32','updated_at' => '2021-03-31 07:05:32'],
        ['id' => 26,'parent_id' => 5,'section_id' => 1,'category_name' => 'Angle Grinder','category_discount' => '0.00','category_description' => '','url' => 'angle-grinders','meta_title' => '','meta_description' => '','meta_keywords' => '','status' => '1','created_at' => '2021-03-31 07:06:56','updated_at' => '2021-03-31 07:06:56'],
        ['id' => 27,'parent_id' => 6,'section_id' => 1,'category_name' => 'Random Orbit Sander','category_discount' => '0.00','category_description' => '','url' => 'random-orbit-sander','meta_title' => '','meta_description' => '','meta_keywords' => '','status' => '1','created_at' => '2021-03-31 07:07:41','updated_at' => '2021-03-31 07:07:41'],
        ['id' => 28,'parent_id' => 6,'section_id' => 1,'category_name' => 'Sheet Palm Sander','category_discount' => '0.00','category_description' => '','url' => 'sheet-palm-sander','meta_title' => '','meta_description' => '','meta_keywords' => '','status' => '1','created_at' => '2021-03-31 07:08:37','updated_at' => '2021-03-31 07:08:37'],
        ['id' => 29,'parent_id' => 6,'section_id' => 1,'category_name' => 'Sheet Finishing Sander','category_discount' => '0.00','category_description' => '','url' => 'sheet-finishing-sander','meta_title' => '','meta_description' => '','meta_keywords' => '','status' => '1','created_at' => '2021-03-31 07:09:21','updated_at' => '2021-03-31 07:09:21'],
        ['id' => 30,'parent_id' => 6,'section_id' => 1,'category_name' => 'Belt Sander','category_discount' => '0.00','category_description' => '','url' => 'belt-sander','meta_title' => '','meta_description' => '','meta_keywords' => '','status' => '1','created_at' => '2021-03-31 07:09:52','updated_at' => '2021-03-31 07:09:52'],
        ['id' => 31,'parent_id' => 7,'section_id' => 1,'category_name' => 'Wood Planner','category_discount' => '0.00','category_description' => '','url' => 'wood-planner','meta_title' => '','meta_description' => '','meta_keywords' => '','status' => '1','created_at' => '2021-03-31 07:14:47','updated_at' => '2021-03-31 07:14:47'],
        ['id' => 32,'parent_id' => 8,'section_id' => 1,'category_name' => 'Jig Saw','category_discount' => '0.00','category_description' => '','url' => 'jig-saw','meta_title' => '','meta_description' => '','meta_keywords' => '','status' => '1','created_at' => '2021-03-31 07:16:29','updated_at' => '2021-03-31 07:16:29'],
        ['id' => 33,'parent_id' => 8,'section_id' => 1,'category_name' => 'Circular Saw','category_discount' => '0.00','category_description' => '','url' => 'circular-saw','meta_title' => '','meta_description' => '','meta_keywords' => '','status' => '1','created_at' => '2021-03-31 07:16:49','updated_at' => '2021-03-31 07:16:49'],
        ['id' => 34,'parent_id' => 8,'section_id' => 1,'category_name' => 'Miter Saw','category_discount' => '0.00','category_description' => '','url' => 'miter-saw','meta_title' => '','meta_description' => '','meta_keywords' => '','status' => '1','created_at' => '2021-03-31 07:17:27','updated_at' => '2021-03-31 07:17:27'],
        ['id' => 35,'parent_id' => 8,'section_id' => 1,'category_name' => 'Table Saw','category_discount' => '0.00','category_description' => '','url' => 'table-saw','meta_title' => '','meta_description' => '','meta_keywords' => '','status' => '1','created_at' => '2021-03-31 07:17:49','updated_at' => '2021-03-31 07:17:49'],
        ['id' => 36,'parent_id' => 9,'section_id' => 1,'category_name' => 'Portable Blower','category_discount' => '0.00','category_description' => '','url' => 'portable-blower','meta_title' => '','meta_description' => '','meta_keywords' => '','status' => '1','created_at' => '2021-03-31 07:19:20','updated_at' => '2021-03-31 07:19:20'],
        ['id' => 37,'parent_id' => 9,'section_id' => 1,'category_name' => 'Heat Gun','category_discount' => '0.00','category_description' => '','url' => 'heat-gun','meta_title' => '','meta_description' => '','meta_keywords' => '','status' => '1','created_at' => '2021-03-31 07:20:02','updated_at' => '2021-03-31 07:20:02'],
        ['id' => 38,'parent_id' => 9,'section_id' => 1,'category_name' => 'Plastic Pipe Welder','category_discount' => '0.00','category_description' => '','url' => 'plastic-pipe-welder','meta_title' => '','meta_description' => '','meta_keywords' => '','status' => '1','created_at' => '2021-03-31 07:20:46','updated_at' => '2021-03-31 07:20:46'],
        ['id' => 39,'parent_id' => 9,'section_id' => 1,'category_name' => 'Marble Cutter','category_discount' => '0.00','category_description' => '','url' => 'marble-cutter','meta_title' => '','meta_description' => '','meta_keywords' => '','status' => '1','created_at' => '2021-03-31 07:21:36','updated_at' => '2021-03-31 07:21:36'],
        ['id' => 40,'parent_id' => 9,'section_id' => 1,'category_name' => 'Mixer','category_discount' => '0.00','category_description' => '','url' => 'mixer','meta_title' => '','meta_description' => '','meta_keywords' => '','status' => '1','created_at' => '2021-03-31 07:22:08','updated_at' => '2021-03-31 07:22:08'],
        ['id' => 41,'parent_id' => 9,'section_id' => 1,'category_name' => 'Paint Sprayer','category_discount' => '0.00','category_description' => '','url' => 'paint-sprayer','meta_title' => '','meta_description' => '','meta_keywords' => '','status' => '1','created_at' => '2021-03-31 07:23:03','updated_at' => '2021-03-31 07:23:03'],
        ['id' => 42,'parent_id' => 9,'section_id' => 1,'category_name' => 'Polisher','category_discount' => '0.00','category_description' => '','url' => 'polisher','meta_title' => '','meta_description' => '','meta_keywords' => '','status' => '1','created_at' => '2021-03-31 07:24:12','updated_at' => '2021-03-31 07:24:12'],
        ['id' => 43,'parent_id' => 9,'section_id' => 1,'category_name' => 'Wood Trimmer','category_discount' => '0.00','category_description' => '','url' => 'wood-trimmer','meta_title' => '','meta_description' => '','meta_keywords' => '','status' => '1','created_at' => '2021-03-31 07:24:58','updated_at' => '2021-03-31 07:24:58'],
        ['id' => 44,'parent_id' => 9,'section_id' => 1,'category_name' => 'Electric Router','category_discount' => '0.00','category_description' => '','url' => 'electric-router','meta_title' => '','meta_description' => '','meta_keywords' => '','status' => '1','created_at' => '2021-03-31 07:25:34','updated_at' => '2021-03-31 07:25:34'],
        ['id' => 45,'parent_id' => 10,'section_id' => 1,'category_name' => 'Bench Grinder','category_discount' => '0.00','category_description' => '','url' => 'bench-grinder','meta_title' => '','meta_description' => '','meta_keywords' => '','status' => '1','created_at' => '2021-03-31 07:26:11','updated_at' => '2021-03-31 07:26:11'],
        ['id' => 46,'parent_id' => 10,'section_id' => 1,'category_name' => 'Drill Press','category_discount' => '0.00','category_description' => '','url' => 'drill-press','meta_title' => '','meta_description' => '','meta_keywords' => '','status' => '1','created_at' => '2021-03-31 07:26:34','updated_at' => '2021-03-31 07:26:34'],
        ['id' => 47,'parent_id' => 10,'section_id' => 1,'category_name' => 'Cut-Off Saw','category_discount' => '0.00','category_description' => '','url' => 'cutoff-saw','meta_title' => '','meta_description' => '','meta_keywords' => '','status' => '1','created_at' => '2021-03-31 07:27:11','updated_at' => '2021-03-31 07:27:11'],
        ['id' => 48,'parent_id' => 11,'section_id' => 1,'category_name' => 'High Pressure Washer','category_discount' => '0.00','category_description' => '','url' => 'high-pressure-washer','meta_title' => '','meta_description' => '','meta_keywords' => '','status' => '1','created_at' => '2021-03-31 07:27:46','updated_at' => '2021-03-31 07:27:46'],
        ['id' => 49,'parent_id' => 12,'section_id' => 1,'category_name' => 'Wielding Machine','category_discount' => '0.00','category_description' => '','url' => 'wielding-machines','meta_title' => '','meta_description' => '','meta_keywords' => '','status' => '1','created_at' => '2021-03-31 07:28:48','updated_at' => '2021-03-31 07:28:48'],
        ['id' => 50,'parent_id' => 13,'section_id' => 1,'category_name' => 'Air Compressor','category_discount' => '0.00','category_description' => '','url' => 'air-compressor','meta_title' => '','meta_description' => '','meta_keywords' => '','status' => '1','created_at' => '2021-03-31 07:29:46','updated_at' => '2021-03-31 07:29:46'],
        ['id' => 51,'parent_id' => 14,'section_id' => 2,'category_name' => '1AT SP Flex H-Hose','category_discount' => '0.00','category_description' => '','url' => '1at-sp-hose','meta_title' => '','meta_description' => '','meta_keywords' => '','status' => '1','created_at' => '2021-03-31 07:33:54','updated_at' => '2021-03-31 07:33:54'],
        ['id' => 52,'parent_id' => 15,'section_id' => 2,'category_name' => '1AT Hammer H-Hose','category_discount' => '0.00','category_description' => '','url' => '1at-hammer-hose','meta_title' => '','meta_description' => '','meta_keywords' => '','status' => '1','created_at' => '2021-03-31 07:33:54','updated_at' => '2021-03-31 07:33:54'],
        ['id' => 53,'parent_id' => 14,'section_id' => 2,'category_name' => '2AT SP Flex H-Hose','category_discount' => '0.00','category_description' => '','url' => '2at-sp-hose','meta_title' => '','meta_description' => '','meta_keywords' => '','status' => '1','created_at' => '2021-03-31 07:33:54','updated_at' => '2021-03-31 07:33:54'],
        ['id' => 54,'parent_id' => 15,'section_id' => 2,'category_name' => '2AT Hammer H-Hose','category_discount' => '0.00','category_description' => '','url' => '2at-hammer-hose','meta_title' => '','meta_description' => '','meta_keywords' => '','status' => '1','created_at' => '2021-03-31 07:33:54','updated_at' => '2021-03-31 07:33:54'],
        ['id' => 55,'parent_id' => 14,'section_id' => 2,'category_name' => '4SH SP Flex H-Hose','category_discount' => '0.00','category_description' => '','url' => '4sh-sp-hose','meta_title' => '','meta_description' => '','meta_keywords' => '','status' => '1','created_at' => '2021-03-31 07:33:54','updated_at' => '2021-03-31 07:33:54'],
        ['id' => 56,'parent_id' => 15,'section_id' => 2,'category_name' => '4SH Hammer H-Hose','category_discount' => '0.00','category_description' => '','url' => '4sh-hammer-hose','meta_title' => '','meta_description' => '','meta_keywords' => '','status' => '1','created_at' => '2021-03-31 07:33:54','updated_at' => '2021-03-31 07:33:54'],
        ['id' => 57,'parent_id' => 16,'section_id' => 3,'category_name' => 'WSD(T) Pump','category_discount' => '0.00','category_description' => '','url' => 'wsd(t)-pump','meta_title' => '','meta_description' => '','meta_keywords' => '','status' => '1','created_at' => '2021-03-31 07:33:54','updated_at' => '2021-03-31 07:33:54'],
        ['id' => 58,'parent_id' => 16,'section_id' => 3,'category_name' => 'WSDS Pump','category_discount' => '0.00','category_description' => '','url' => 'wsds-pump','meta_title' => '','meta_description' => '','meta_keywords' => '','status' => '1','created_at' => '2021-03-31 07:33:54','updated_at' => '2021-03-31 07:33:54'],
        ['id' => 59,'parent_id' => 17,'section_id' => 3,'category_name' => 'AWZB-H [PW] Pump','category_discount' => '0.00','category_description' => '','url' => 'pw-booster-pump','meta_title' => '','meta_description' => '','meta_keywords' => '','status' => '1','created_at' => '2021-03-31 07:35:20','updated_at' => '2021-03-31 07:35:20'],
        ['id' => 60,'parent_id' => 17,'section_id' => 3,'category_name' => 'QB Pump','category_discount' => '0.00','category_description' => '','url' => 'qb-pump','meta_title' => '','meta_description' => '','meta_keywords' => '','status' => '1','created_at' => '2021-03-31 07:36:15','updated_at' => '2021-03-31 07:36:15'],
        ['id' => 61,'parent_id' => 17,'section_id' => 3,'category_name' => 'SGJW Pump','category_discount' => '0.00','category_description' => '','url' => 'sgjw-pump','meta_title' => '','meta_description' => '','meta_keywords' => '','status' => '1','created_at' => '2021-03-31 07:36:57','updated_at' => '2021-03-31 07:36:57'],
        ['id' => 62,'parent_id' => 17,'section_id' => 3,'category_name' => 'SHF(m) Pump','category_discount' => '0.00','category_description' => '','url' => 'shf(m)-pump','meta_title' => '','meta_description' => '','meta_keywords' => '','status' => '1','created_at' => '2021-03-31 07:38:11','updated_at' => '2021-03-31 07:38:11'],
        ['id' => 63,'parent_id' => 17,'section_id' => 3,'category_name' => 'CPm Pump','category_discount' => '0.00','category_description' => '','url' => 'cpm-pump','meta_title' => '','meta_description' => '','meta_keywords' => '','status' => '1','created_at' => '2021-03-31 07:38:46','updated_at' => '2021-03-31 07:38:46'],
        ['id' => 64,'parent_id' => 17,'section_id' => 3,'category_name' => 'JET Pump','category_discount' => '0.00','category_description' => '','url' => 'jet-pump','meta_title' => '','meta_description' => '','meta_keywords' => '','status' => '1','created_at' => '2021-03-31 07:38:46','updated_at' => '2021-03-31 07:38:46'],
        ['id' => 65,'parent_id' => 17,'section_id' => 3,'category_name' => 'JET-G1 Pump','category_discount' => '0.00','category_description' => '','url' => 'jetg1-pump','meta_title' => '','meta_description' => '','meta_keywords' => '','status' => '1','created_at' => '2021-03-31 07:38:46','updated_at' => '2021-03-31 07:38:46'],
        ['id' => 66,'parent_id' => 17,'section_id' => 3,'category_name' => '2SGP(m) [SFG32] Pump','category_discount' => '0.00','category_description' => '','url' => 'sfg32-pump','meta_title' => '','meta_description' => '','meta_keywords' => '','status' => '1','created_at' => '2021-03-31 07:38:46','updated_at' => '2021-03-31 07:38:46'],
        ];

        Category::insert($categoryRecords);
    }
}