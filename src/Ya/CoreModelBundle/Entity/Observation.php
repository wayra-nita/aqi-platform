<?php

namespace Ya\CoreModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ya\CoreModelBundle\Entity\DataTypeEnum as DataTypeEnum;
use Ya\CoreModelBundle\Entity\SequenceEnum as SequenceEnum;
use Ya\CoreModelBundle\Entity\AirQualityCategory as AirQualityCategory;

/**
 * Observation
 *
 * @ORM\Table("observation")
 * @ORM\Entity(repositoryClass="Ya\CoreModelBundle\Entity\Repository\ObservationRepository")
 */
class Observation
{
  /**
   * @var integer
   *
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  protected $id;

  /**
   * @var Partner
   * Partner that is providing the observations
   *
   * @ORM\ManyToOne(targetEntity="Partner", inversedBy="observations")
   * @ORM\JoinColumn(name="partner_id", referencedColumnName="id")
   */
  protected $partner;

  /**
   * @var \DateTime
   * Local date that forecast is issued. Note that for current and yesterday’s observed AQI,
   * this field is always today’s date.
   *
   * @ORM\Column(name="issue_date", type="date", nullable=true)
   */
  protected $issueDate;

  /**
   * @var \DateTime
   * Local date for which forecast is valid or local date on which an observation is made.
   *
   * @ORM\Column(name="valid_date", type="date", nullable=true)
   */
  protected $validDate;

  /**
   * @var String
   * Time zone for report observations. Note that for forecasts and yesterday’s AQI, this field will be blank.
   *
   * @ORM\Column(name="time_zone", type="string", length=3, nullable=true)
   */
  protected $timeZone;

  /**
   * @var SequenceEnum
   * Indicates the day number of a forecast or whether it is an observation.
   *
   * @ORM\ManyToOne(targetEntity="SequenceEnum", inversedBy="observations")
   * @ORM\JoinColumn(name="sequence_enum_id", referencedColumnName="id")
   */
  protected $sequence;

  /**
   * @var DataTypeEnum
   * F: Forecast Y: Yesterday’s AQI : Hourly AQI Observation
   *
   * @ORM\ManyToOne(targetEntity="DataTypeEnum", inversedBy="observations")
   * @ORM\JoinColumn(name="data_type_enum_id", referencedColumnName="id")
   */
  protected $dataType;

  /**
   * @var AirQualityCategory
   * Category of the Air Quality condition:
   *    Good (0-50 AQI)
   *    Moderate (51-100 AQI)
   *    Unhealthy for Sensitive Groups (101-150 AQI)
   *    Unhealthy (151-200 AQI)
   *    Very Unhealthy (201-300 AQI)
   *    Hazardous (>300 AQI)
   * @ORM\ManyToOne(targetEntity="AirQualityCategory", inversedBy="observations")
   * @ORM\JoinColumn(name="air_quality_category_id", referencedColumnName="id")
   */
  protected $airQualityCategory;

  /**
   * @var ReportingArea
   * Name of the area for reported values and AQI
   *
   * @ORM\ManyToOne(targetEntity="ReportingArea", inversedBy="observations")
   * @ORM\JoinColumn(name="reporting_area_id", referencedColumnName="id")
   */
  protected $reportingArea;

  /**
   * @var boolean
   * Indicates if is primary pollutant (i.e., highest AQI reading) or not
   *
   * @ORM\Column(name="is_primary", type="boolean")
   */
  protected $isPrimary;

  /**
   * @var String
   * Name of the parameter reported in that record.
   *
   * @ORM\Column(name="parameter_name", type="string", length=10, nullable=true)
   */
  protected $parameterName;

  /**
   * @var integer
   * 0 to 500. AQI value for the reporting area for the day.
   * This field is blank for cities with only AQI categorical forecasts.
   *
   * @ORM\Column(name="aqi_value", type="boolean", nullable=true)
   */
  protected $aqiValue;

  /**
   * @var boolean
   * This field indicates whether an air quality action day is issued
   *
   * @ORM\Column(name="is_action_day", type="boolean")
   */
  protected $isActionDay;

  /**
   * @var String
   * Forecast discussion. Note that for hourly AQI observations and cities without forecast discussions,
   * this field will be blank.
   *
   * @ORM\Column(name="discussion", type="text", nullable=true)
   */
  protected $discussion;

  /**
   * @var String
   * Name of agency submitting forecast.
   *
   * @ORM\Column(name="forecast_source", type="string", length=100, nullable=true)
   */
  protected $forecastSource;


  /**
   * Get id
   *
   * @return integer
   */
  public function getId()
  {
    return $this->id;
  }

  /**
   * Set issueDate
   *
   * @param \DateTime $issueDate
   * @return Observation
   */
  public function setIssueDate($issueDate)
  {
    $this->issueDate = $issueDate;

    return $this;
  }

  /**
   * Get issueDate
   *
   * @return \DateTime
   */
  public function getIssueDate()
  {
    return $this->issueDate;
  }

  /**
   * Set validDate
   *
   * @param \DateTime $validDate
   * @return Observation
   */
  public function setValidDate($validDate)
  {
    $this->validDate = $validDate;

    return $this;
  }

  /**
   * Get validDate
   *
   * @return \DateTime
   */
  public function getValidDate()
  {
    return $this->validDate;
  }

  /**
   * Set timeZone
   *
   * @param string $timeZone
   * @return Observation
   */
  public function setTimeZone($timeZone)
  {
    $this->timeZone = $timeZone;

    return $this;
  }

  /**
   * Get timeZone
   *
   * @return string
   */
  public function getTimeZone()
  {
    return $this->timeZone;
  }

  /**
   * Set isPrimary
   *
   * @param boolean $isPrimary
   * @return Observation
   */
  public function setIsPrimary($isPrimary)
  {
    $this->isPrimary = $isPrimary;

    return $this;
  }

  /**
   * Get isPrimary
   *
   * @return boolean
   */
  public function getIsPrimary()
  {
    return $this->isPrimary;
  }

  /**
   * Set parameterName
   *
   * @param string $parameterName
   * @return Observation
   */
  public function setParameterName($parameterName)
  {
    $this->parameterName = $parameterName;

    return $this;
  }

  /**
   * Get parameterName
   *
   * @return string
   */
  public function getParameterName()
  {
    return $this->parameterName;
  }

  /**
   * Set aqiValue
   *
   * @param boolean $aqiValue
   * @return Observation
   */
  public function setAqiValue($aqiValue)
  {
    $this->aqiValue = $aqiValue;

    return $this;
  }

  /**
   * Get aqiValue
   *
   * @return boolean
   */
  public function getAqiValue()
  {
    return $this->aqiValue;
  }

  /**
   * Set isActionDay
   *
   * @param boolean $isActionDay
   * @return Observation
   */
  public function setIsActionDay($isActionDay)
  {
    $this->isActionDay = $isActionDay;

    return $this;
  }

  /**
   * Get isActionDay
   *
   * @return boolean
   */
  public function getIsActionDay()
  {
    return $this->isActionDay;
  }

  /**
   * Set discussion
   *
   * @param string $discussion
   * @return Observation
   */
  public function setDiscussion($discussion)
  {
    $this->discussion = $discussion;

    return $this;
  }

  /**
   * Get discussion
   *
   * @return string
   */
  public function getDiscussion()
  {
    return $this->discussion;
  }

  /**
   * Set forecastSource
   *
   * @param string $forecastSource
   * @return Observation
   */
  public function setForecastSource($forecastSource)
  {
    $this->forecastSource = $forecastSource;

    return $this;
  }

  /**
   * Get forecastSource
   *
   * @return string
   */
  public function getForecastSource()
  {
    return $this->forecastSource;
  }

  /**
   * Set partner
   *
   * @param \Ya\CoreModelBundle\Entity\Partner $partner
   * @return Observation
   */
  public function setPartner(\Ya\CoreModelBundle\Entity\Partner $partner = null)
  {
    $this->partner = $partner;

    return $this;
  }

  /**
   * Get partner
   *
   * @return \Ya\CoreModelBundle\Entity\Partner
   */
  public function getPartner()
  {
    return $this->partner;
  }

  /**
   * Set sequence
   *
   * @param \Ya\CoreModelBundle\Entity\SequenceEnum $sequence
   * @return Observation
   */
  public function setSequence(\Ya\CoreModelBundle\Entity\SequenceEnum $sequence = null)
  {
    $this->sequence = $sequence;

    return $this;
  }

  /**
   * Get sequence
   *
   * @return \Ya\CoreModelBundle\Entity\SequenceEnum
   */
  public function getSequence()
  {
    return $this->sequence;
  }

  /**
   * Set dataType
   *
   * @param \Ya\CoreModelBundle\Entity\DataTypeEnum $dataType
   * @return Observation
   */
  public function setDataType(\Ya\CoreModelBundle\Entity\DataTypeEnum $dataType = null)
  {
    $this->dataType = $dataType;

    return $this;
  }

  /**
   * Get dataType
   *
   * @return \Ya\CoreModelBundle\Entity\DataTypeEnum
   */
  public function getDataType()
  {
    return $this->dataType;
  }

  /**
   * Set airQualityCategory
   *
   * @param \Ya\CoreModelBundle\Entity\AirQualityCategory $airQualityCategory
   * @return Observation
   */
  public function setAirQualityCategory(\Ya\CoreModelBundle\Entity\AirQualityCategory $airQualityCategory = null)
  {
    $this->airQualityCategory = $airQualityCategory;

    return $this;
  }

  /**
   * Get airQualityCategory
   *
   * @return \Ya\CoreModelBundle\Entity\AirQualityCategory
   */
  public function getAirQualityCategory()
  {
    return $this->airQualityCategory;
  }

  /**
   * Set reportingArea
   *
   * @param \Ya\CoreModelBundle\Entity\ReportingArea $reportingArea
   * @return Observation
   */
  public function setReportingArea(\Ya\CoreModelBundle\Entity\ReportingArea $reportingArea = null)
  {
    $this->reportingArea = $reportingArea;

    return $this;
  }

  /**
   * Get reportingArea
   *
   * @return \Ya\CoreModelBundle\Entity\ReportingArea
   */
  public function getReportingArea()
  {
    return $this->reportingArea;
  }
}