UPDATE d3modprofile SET oxshopid = 1 WHERE oxmodid = 'd3_ordermanager' AND oxshopid = 'oxbaseshop';
UPDATE oxcontent SET oxshopid = 1 WHERE oxloadid IN ('d3payreminder', 'd3payreminder_plain') AND oxshopid = 'oxbaseshop';
UPDATE d3modprofile2shop LEFT JOIN d3modprofile ON d3modprofile2shop.oxmapobjectid = d3modprofile.oxmapid SET d3modprofile2shop.oxshopid = 1 WHERE d3modprofile.oxmodid = 'd3_ordermanager' AND d3modprofile2shop.oxshopid = 'oxbaseshop';
