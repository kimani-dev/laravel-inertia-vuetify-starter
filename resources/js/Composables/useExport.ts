import Exportable from "@/types/Exportable";
import jsPDF from "jspdf";
import autoTable from "jspdf-autotable";

export function useExport({ head, body, title = "table" }: Exportable) {
    // set the title of the document
    const doc = new jsPDF();
    doc.text(title, 14, 10);

    // add numbers to the head and body arrays
    head.unshift("#");
    body.forEach((row, index) => {
        row.unshift((index + 1).toString());
    });

    autoTable(doc, {
        head: [head],
        body: body,
    });

    function savePDF() {
        doc.save(`${title}.pdf`);
    }

    return {
        savePDF,
    };
}
