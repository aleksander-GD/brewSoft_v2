DROP SCHEMA if exists brewSoftDBTest cascade;

CREATE SCHEMA if not exists brewSoftDBTest;
SET search_path = brewSoftDBTest;

Create Table BreweryMachine (
BreweryMachineID serial Primary Key,
Hostname VARCHAR (255),
Port int
);

Create table ProductionList(
ProductionListID serial Primary key,
BatchID int,
ProductID int,
ProductAmount int,
Deadline date,
Speed float,
Status VARCHAR(20),
DateOfCreation date DEFAULT CURRENT_DATE
);

Create Table ProductType (
ProductID int Primary key,
ProductName VARCHAR (20),
Speed float,
IdealCycleTime float
);  

Create Table FinalBatchInformation(
FinalBatchInformationID serial Primary key,
ProductionListID int,
BreweryMachineID int,
Deadline Date,
DateOfCreation Date,
DateOfCompletion Date DEFAULT current_date,
ProductID int,
TotalCount int,
DefectCount float,
AcceptedCount float
);

create table ProductionInfo(
ProductionInfoID serial primary key,
ProductionListID int,
BreweryMachineID int,
Humidity float,
Temperature float,
EntryTime time DEFAULT current_time,
EntryDate Date DEFAULT current_date
);

Create table TimeInState(
TimeInStateID serial Primary key,
ProductionListID int,
BreweryMachineID int,
StartTimeInState time DEFAULT current_time,
MachineStateID int
);

Create table StopDuringProduction(
StopDuringProductionID serial Primary key,
ProductionListID int,
BreweryMachineID int,
StopReasonID int,
EntryTime time DEFAULT current_time
);

create table manualStopReasen(
    manualStopReasenid serial primary key,
    StopDuringProductionID int,
    Reason TEXT,
    userid int
);

create table StopReason(
StopReasonID int primary Key,
Reason VARCHAR (50)
);

create table MachineState (
MachineStateID int primary key,
MachineState VARCHAR (50)
);

CREATE TABLE temporaryproduction (
    temporaryproductionid serial,
    productionlistid int,
    acceptedcount float,
    defectcount float,
    dateforstop date DEFAULT current_date,
    PRIMARY KEY (temporaryproductionid),
    FOREIGN KEY (productionlistid) REFERENCES productionlist(productionlistid)
);

CREATE TABLE alarmlog (
    alarmid SERIAL PRIMARY KEY,
    productioninfoid INT,
    alarm VARCHAR(50),
    EntryTime TIME DEFAULT current_time,
    FOREIGN KEY (productioninfoid) REFERENCES productioninfo(productioninfoid)
);

create table user(
userid serial Primary key,
username VARCHAR(255),
password VARCHAR(255),
usertype VARCHAR(255)
);

CREATE TABLE ingredientsUpdate(
    ingredientsid serial,
    barley INT,
    hops INT,
    malt INT,
    wheat INT,
    yeast INT,
    BreweryMachineID INT,
    timestamp time DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (ingredientsid),
);

CREATE TABLE machinedata(
    machinedataid serial,
    brewerymachineid INT,
    maintenace FLOAT,
    state INT,
    timestamp time DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (machinedataid)
);

CREATE TABLE produceddata(
    produceddataid serial,
    ProductionListID INT,
    produced INT,
    acceptable INT,
    defect INT,
    timestamp time DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (produceddataid),
);

insert into user(username,password,usertype) VALUES('manager','manager','wanager');
insert into user(username,password,usertype) VALUES('worker','worker','worker');

insert into brewerymachine (Hostname, Port) values ('192.168.0.122',4840);
insert into brewerymachine (Hostname, Port) values ('127.0.0.1', 4840);

insert into ProductType (ProductID, ProductName, Speed, IdealCycleTime) values (0,'Pilsner', 200, 0.3);
insert into ProductType (ProductID, ProductName, Speed, IdealCycleTime) values (1,'Wheat', 25, 2.4);
insert into ProductType (ProductID, ProductName, Speed, IdealCycleTime) values (2,'IPA', 50, 1.2);
insert into ProductType (ProductID, ProductName, Speed, IdealCycleTime) values (3,'Stout', 200, 0.3333);
insert into ProductType (ProductID, ProductName, Speed, IdealCycleTime) values (4,'Ale', 25, 2.4);
insert into ProductType (ProductID, ProductName, Speed, IdealCycleTime) values (5,'Alcohol Free', 25, 2.4);

insert into StopReason (StopReasonID, Reason) values (10, 'Empty inventory');
insert into StopReason (StopReasonID, Reason) values (11, 'Maintenance');
insert into StopReason (StopReasonID, Reason) values (12, 'Manual Stop');
insert into StopReason (StopReasonID, Reason) values (13, 'Motor power loss');
insert into StopReason (StopReasonID, Reason) values (14, 'Manual abort');


insert into MachineState (MachineStateID, MachineState ) values (0, 'Deactivated');
insert into MachineState (MachineStateID, MachineState ) values (1, 'Clearing');
insert into MachineState (MachineStateID, MachineState ) values (2, 'Stopped');
insert into MachineState (MachineStateID, MachineState ) values (3, 'Starting');
insert into MachineState (MachineStateID, MachineState) values (4, 'Idle');
insert into MachineState (MachineStateID, MachineState ) values (5, 'Suspended');
insert into MachineState (MachineStateID, MachineState ) values (6, 'Execute');
insert into MachineState (MachineStateID, MachineState ) values (7, 'Stopping');
insert into MachineState (MachineStateID, MachineState ) values (8, 'Aborting');
insert into MachineState (MachineStateID, MachineState ) values (9, 'Aborted');
insert into MachineState (MachineStateID, MachineState ) values (10, 'Holding');
insert into MachineState (MachineStateID, MachineState ) values (11, 'Held');
insert into MachineState (MachineStateID, MachineState ) values (15, 'Resetting');
insert into MachineState (MachineStateID, MachineState ) values (16, 'Completing');
insert into MachineState (MachineStateID, MachineState ) values (17, 'Complete');
insert into MachineState (MachineStateID, MachineState ) values (18, 'Deactivating');
insert into MachineState (MachineStateID, MachineState ) values (19, 'Activating');


ALTER TABLE ProductionList
ADD CONSTRAINT productionList_productType FOREIGN KEY (ProductID) REFERENCES ProductType;

ALTER TABLE FinalBatchInformation
ADD CONSTRAINT finalBatchInformation_productType FOREIGN KEY (ProductID) REFERENCES ProductType;

ALTER TABLE FinalBatchInformation
ADD CONSTRAINT finalBatchInformation_productionList FOREIGN KEY (ProductionListID) REFERENCES ProductionList;

ALTER TABLE FinalBatchInformation
ADD CONSTRAINT finalBatchInformation_BreweryMachine FOREIGN KEY (BreweryMachineID) REFERENCES BreweryMachine;

ALTER TABLE StopDuringProduction
ADD CONSTRAINT stopDuringProduction_productionList FOREIGN KEY (ProductionListID) REFERENCES ProductionList;

ALTER TABLE StopDuringProduction
ADD CONSTRAINT stopDuringProduction_stopReason FOREIGN KEY (StopReasonID) REFERENCES StopReason;

ALTER TABLE StopDuringProduction
ADD CONSTRAINT stopDuringProduction_breweryMachine FOREIGN KEY (BreweryMachineID) REFERENCES BreweryMachine;

ALTER TABLE ProductionInfo
ADD CONSTRAINT productionInfo_productionList FOREIGN KEY (ProductionListID) REFERENCES ProductionList;

ALTER TABLE ProductionInfo
ADD CONSTRAINT productionInfo_BreweryMachine FOREIGN KEY (BreweryMachineID) REFERENCES BreweryMachine;

ALTER TABLE TimeInState
ADD CONSTRAINT timeInState_productionList FOREIGN KEY (ProductionListID) REFERENCES ProductionList;

ALTER TABLE TimeInState
ADD CONSTRAINT timeInState_breweryMachine FOREIGN KEY (BreweryMachineID) REFERENCES BreweryMachine;

ALTER TABLE TimeInState
ADD CONSTRAINT timeInState_machineState FOREIGN KEY (MachineStateID) REFERENCES MachineState;

ALTER TABLE ProductionInfo
ADD vibration float;

ALTER TABLE ingredientsUpdate
ADD CONSTRAINT ingredientsUpdate_BreweryMachineID FOREIGN KEY (BreweryMachineID) REFERENCES brewerymachine;

ALTER TABLE machinedata
ADD CONSTRAINT machinedata_BreweryMachineID FOREIGN KEY (BreweryMachineID) REFERENCES brewerymachine;

ALTER TABLE produceddata
ADD CONSTRAINT produceddata_BreweryMachineID FOREIGN KEY (BreweryMachineID) REFERENCES brewerymachine;

ALTER TABLE ProductionList
ADD machineid INT;

ALTER TABLE ProductionList
ADD CONSTRAINT productionlist_machineid FOREIGN KEY (BreweryMachineID) REFERENCES BreweryMachine;