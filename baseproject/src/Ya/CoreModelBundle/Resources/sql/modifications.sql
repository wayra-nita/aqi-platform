UPDATE air-quality.air_quality_category_enum SET max = '50' WHERE air_quality_category_enum.id = 1;
UPDATE air-quality.air_quality_category_enum SET min = '51', max = '100' WHERE air_quality_category_enum.id = 2;
UPDATE air-quality.air_quality_category_enum SET min = '101', max = '150' WHERE air_quality_category_enum.id = 3;
UPDATE air-quality.air_quality_category_enum SET min = '151', max = '200' WHERE air_quality_category_enum.id = 4;
UPDATE air-quality.air_quality_category_enum SET min = '201', max = '300' WHERE air_quality_category_enum.id = 5;
UPDATE air-quality.air_quality_category_enum SET min = '301', max = '10000000' WHERE air_quality_category_enum.id = 6;