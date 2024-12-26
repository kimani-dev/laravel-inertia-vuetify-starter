import ResponseData from "./ResponseData";

export default interface DataTableProps {
    headers: { title: string; value: string }[];
    hideActions?: boolean;
    items: ResponseData<Record<string, any>[]>;
    hasDateRange?: boolean; // if yes, date will be passed as start_date and end_date to your route
    routeName: string;
    routeNameIsFull?: boolean;
    routeParams?: Record<string, any>;
    overrideEdit?: boolean;
    overrideDelete?: boolean;
}
