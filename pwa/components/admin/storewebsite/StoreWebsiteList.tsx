import { FieldGuesser } from "@api-platform/admin";
import { Datagrid, EditButton, List, TextInput, useRecordContext, WrapperField } from "react-admin";

export const StoreWebsiteList = () => (
  <List exporter={false} title="Store Website">
    <Datagrid>
      <FieldGuesser source="name" />
      <FieldGuesser source="code" />
    </Datagrid>
  </List>
);

/*
import {ShowButton} from "./ShowButton";
import {RatingField} from "../review/RatingField";
import {ConditionInput} from "./ConditionInput";


const ConditionField = () => {
  const record = useRecordContext();
  if (!record || !record.condition) return null;
  return (
    <span>
      {record.condition.replace(/https:\/\/schema\.org\/(.+)Condition$/, "$1")}
    </span>
  );
};

const filters = [
  <TextInput source="title" key="title" />,
  <TextInput source="author" key="author" />,
  <ConditionInput source="condition" key="condition" />,
];

export const BooksList = () => (
  <List filters={filters} exporter={false} title="Books">
    <Datagrid>
      <FieldGuesser source="title" />
      <FieldGuesser source="author" sortable={false} />
      <WrapperField label="Condition" sortable={false}>
        <ConditionField />
      </WrapperField>
      <WrapperField label="Rating" sortable={false}>
        <RatingField />
      </WrapperField>
      <ShowButton />
      <EditButton />
    </Datagrid>
  </List>
);

*/
